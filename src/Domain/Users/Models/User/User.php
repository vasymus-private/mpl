<?php

namespace Domain\Users\Models\User;

use App\Models\BaseModel;
use App\Models\CommonTraits;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\Pivots\OrderProduct;
use Domain\Users\Models\Pivots\ProductUserAside;
use Domain\Users\Models\Pivots\ProductUserCart;
use Domain\Users\Models\Pivots\ProductUserViewed;
use Domain\Users\Models\Pivots\ServiceUserViewed;
use Domain\Products\Models\Product\Product;
use Domain\Products\Collections\ProductCollection;
use App\Models\Service;
use App\Models\UserSessionUuid;
use Carbon\Carbon;
use Domain\Users\Models\Admin;
use Domain\Users\QueryBuilders\UserQueryBuilder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\UuidInterface;

// if will use HasMediaTrait do not forget to call parent::registerMediaCollections() in Admin
/**
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property int $status
 * @property string|null $password
 * @property string|null $remember_token
 *
 * @property string|null $phone
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Carbon|null $email_verified_at
 *
 * Properties from Accessors / Mutators
 * @see User::getIsAdminAttribute()
 * @property bool $is_admin
 *
 * @see User::getIsSuperAdminAttribute()
 * @property bool $is_super_admin
 *
 * @see User::getIsAnonymousAttribute()
 * @property bool $is_anonymous
 *
 * @see User::getIsIdentifiedAttribute()
 * @property bool $is_identified
 *
 * @see User::getIsAnonymous2Attribute()
 * @property bool $is_anonymous2
 *
 * @see User::products()
 * @property Product[]|\Domain\Products\Collections\ProductCollection $products
 *
 * @see User::cart()
 * @property Product[]|\Domain\Products\Collections\ProductCollection $cart
 *
 * @see User::viewed()
 * @property Product[]|\Domain\Products\Collections\ProductCollection $viewed
 *
 * @see User::serviceViewed()
 * @property Service[]|Collection $serviceViewed
 *
 * @see User::aside()
 * @property Product[]|\Domain\Products\Collections\ProductCollection $aside
 *
 * @see User::orders()
 * @property Order[]|Collection $orders
 *
 * @see User::userSessionUuids()
 * @property UserSessionUuid[]|Collection $userSessionUuids
 *
 * @see User::setCurrentUserSessionUuid()
 * @property UserSessionUuid|null $currentSessionUuid
 *
 * @see User::getCartNotTrashedAttribute()
 * @property \Domain\Products\Collections\ProductCollection|Product[] $cart_not_trashed
 *
 * @method static static|UserQueryBuilder query()
 *
 * @mixin BaseModel
 * */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use CommonTraits;

    const TABLE = "users";

    const ADMIN_THRESHOLD = 5;
    const SUPER_ADMIN = 10;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'email_verified_at',
    ];

    public static function createAnonymous(): self // todo move to separate action class
    {
        return static::create();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new UserQueryBuilder($query);
    }

    public function setCurrentUserSessionUuid(UserSessionUuid $userSessionUuid)
    {
        $this->setRelation("currentSessionUuid", $userSessionUuid);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->status >= static::ADMIN_THRESHOLD;
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->status >= static::SUPER_ADMIN;
    }

    public function getIsAnonymousAttribute(): bool
    {
        $viaCredentials = $this->currentSessionUuid->via_credentials ?? false;
        return !$viaCredentials;
    }

    public function getIsIdentifiedAttribute(): bool
    {
        return !empty($this->email);
    }

    public function getIsAnonymous2Attribute(): bool
    {
        return empty($this->email);
    }

    public function identificate(UuidInterface $uuid) // todo move to separate action class
    {
        $userSessionUuid = UserSessionUuid::unguarded(function() use($uuid) {
            UserSessionUuid::query()->firstOrCreate([
                "session_uuid" => $uuid->toString(),
                "user_id" => $this->id,
            ]);
        });
        $userSessionUuid->via_credentials = true;
        $userSessionUuid->save();
        $this->setCurrentUserSessionUuid($userSessionUuid);
    }

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserCart::TABLE)->using(ProductUserCart::class)->as('cart_product')->withPivot(["count", "created_at", "deleted_at"])->withTimestamps();
    }

    public function viewed(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserViewed::TABLE)->using(ProductUserViewed::class)->as('viewed_product')->withPivot(["created_at"])->withTimestamps();
    }

    public function serviceViewed(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, ServiceUserViewed::TABLE)->using(ServiceUserViewed::class)->as('viewed_service')->withPivot(['created_at'])->withTimestamps();
    }

    public function aside(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserAside::TABLE)->using(ProductUserAside::class)->as('aside_product')->withPivot(["created_at"])->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "user_id", "id");
    }

    public function getCartNotTrashedAttribute(): Collection
    {
        return $this->cart->cartProductNotTrashed();
    }

    public function userSessionUuids(): HasMany
    {
        return $this->hasMany(UserSessionUuid::class, "user_id", "id");
    }

    public static function handleTransferProducts(self $from, self $to)
    {
        $viewedPrepared = [];
        $from->viewed->each(function(Product $product) use(&$viewedPrepared) {
            $viewedPrepared[$product->id] = [
                "created_at" => $product->viewed_product->created_at ?? null,
                "updated_at" => $product->viewed_product->updated_at ?? null,
            ];
        });
        $to->viewed()->sync($viewedPrepared);

        $cartPrepared = [];
        $from->cart_not_trashed->each(function(Product $product) use(&$cartPrepared) {
            $cartPrepared[$product->id] = [
                "created_at" => $product->cart_product->created_at ?? null,
                "updated_at" => $product->cart_product->updated_at ?? null,
                "deleted_at" => $product->cart_product->deleted_at ?? null,
            ];
        });
        $to->cart()->sync($cartPrepared);

        $asidePrepared = [];
        $from->aside->each(function(Product $product) use(&$asidePrepared) {
            $asidePrepared[$product->id] = [
                "created_at" => $product->aside_product->created_at ?? null,
                "updated_at" => $product->aside_product->updated_at ?? null,
            ];
        });
        $to->aside()->sync($asidePrepared);
    }

    public static function handleTransferOrders(self $from, self $to)
    {
        $from->orders->each(function(Order $order) use($to) {
            $order->user_id = $to->id;
            $order->save();
        });
    }
}
