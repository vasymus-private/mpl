<?php

namespace App\Models\User;

use App\Models\BaseModel;
use App\Models\CommonTraits;
use App\Models\Order;
use App\Models\Pivots\OrderProduct;
use App\Models\Pivots\ProductUserAside;
use App\Models\Pivots\ProductUserCart;
use App\Models\Pivots\ProductUserViewed;
use App\Models\Pivots\ServiceUserViewed;
use App\Models\Product\Product;
use App\Models\Product\ProductCollection;
use App\Models\Service;
use App\Models\UserSessionUuid;
use Carbon\Carbon;
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
 * @property bool $isAdmin
 *
 * @see User::getIsSuperAdminAttribute()
 * @property bool $is_super_admin
 *
 * @see User::getIsAnonymousAttribute()
 * @property bool $is_anonymous
 *
 * @see User::products()
 * @property Product[]|ProductCollection $products
 *
 * @see User::cart()
 * @property Product[]|ProductCollection $cart
 *
 * @see User::viewed()
 * @property Product[]|ProductCollection $viewed
 *
 * @see User::serviceViewed()
 * @property Service[]|Collection $serviceViewed
 *
 * @see User::aside()
 * @property Product[]|ProductCollection $aside
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

    public static function firstOrCreateBySessionUuid(UuidInterface $sessionUuid): self // todo move to separate action class
    {
        /** @see User::$userSessionUuids */
        /** @var User|null $user */
        $user = static::query()->firstBySessionUuid($sessionUuid);
        if ($user) return $user;

        $user = User::create();
        $userSessionUuid = UserSessionUuid::createBySessionUuid($user, $sessionUuid);

        $user->setCurrentUserSessionUuid($userSessionUuid);

        return $user;
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
        return $this->currentSessionUuid->via_credentials ?? false;
    }

    public function recognizeAnonymous(UuidInterface $uuid) // todo move to separate action class
    {
        $userSessionUuid = UserSessionUuid::query()->forceCreate([
            "session_uuid" => $uuid->toString(),
            "user_id" => $this->id,
            "via_credentials" => true,
        ]);
        $this->setCurrentUserSessionUuid($userSessionUuid);
    }

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserCart::TABLE)->using(ProductUserCart::class)->withPivot(["count", "created_at", "deleted_at"])->withTimestamps();
    }

    public function viewed(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserViewed::TABLE)->using(ProductUserViewed::class)->withPivot(["created_at"])->withTimestamps();
    }

    public function serviceViewed(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, ServiceUserViewed::TABLE)->using(ServiceUserViewed::class)->withPivot(['created_at'])->withTimestamps();
    }

    public function aside(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserAside::TABLE)->using(ProductUserAside::class)->withPivot(["created_at"])->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "user_id", "id");
    }

    public function userSessionUuids(): HasMany
    {
        return $this->hasMany(UserSessionUuid::class, "user_id", "id");
    }

    public static function handleTransfer(self $from, self $to)
    {
        $viewedPrepared = [];
        $from->viewed->each(function(Product $product) use(&$viewedPrepared) {
            $viewedPrepared[$product->id] = [
                "created_at" => $product->pivot->created_at ?? null,
                "updated_at" => $product->pivot->updated_at ?? null,
            ];
        });
        $to->viewed()->attach($viewedPrepared);

        $cartPrepared = [];
        $from->cart->each(function(Product $product) use(&$cartPrepared) {
            $cartPrepared[$product->id] = [
                "created_at" => $product->pivot->created_at ?? null,
                "updated_at" => $product->pivot->updated_at ?? null,
                "deleted_at" => $product->pivot->deleted_at ?? null,
            ];
        });
        $to->cart()->attach($cartPrepared);

        $asidePrepared = [];
        $from->aside->each(function(Product $product) use(&$asidePrepared) {
            $asidePrepared[$product->id] = [
                "created_at" => $product->pivot->created_at ?? null,
                "updated_at" => $product->pivot->updated_at ?? null,
            ];
        });
        $to->aside()->attach($asidePrepared);
    }
}
