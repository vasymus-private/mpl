<?php

namespace Domain\Users\Models\BaseUser;

use Domain\Common\Models\CommonTraits;
use Domain\Orders\Models\Order;
use Domain\Products\Models\Product\Product;
use Domain\Services\Models\Service;
use Domain\Users\Models\Pivots\ProductUserAside;
use Domain\Users\Models\Pivots\ProductUserCart;
use Domain\Users\Models\Pivots\ProductUserViewed;
use Domain\Users\Models\Pivots\ServiceUserViewed;
use Domain\Users\QueryBuilders\UserQueryBuilder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property \Carbon\Carbon|null $email_verified_at
 *
 * Properties from Accessors / Mutators
 * @see \Domain\Users\Models\BaseUser\BaseUser::getIsAdminAttribute()
 * @property bool $is_admin
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getIsSuperAdminAttribute()
 * @property bool $is_super_admin
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getIsIdentifiedAttribute()
 * @property bool $is_identified
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getIsAnonymous2Attribute()
 * @property bool $is_anonymous2
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::products()
 * @property \Domain\Products\Models\Product\Product[]|\Domain\Products\Collections\ProductCollection $products
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::cart()
 * @property \Domain\Products\Models\Product\Product[]|\Domain\Products\Collections\ProductCollection $cart
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::viewed()
 * @property \Domain\Products\Models\Product\Product[]|\Domain\Products\Collections\ProductCollection $viewed
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::serviceViewed()
 * @property \Domain\Services\Models\Service[]|\Illuminate\Database\Eloquent\Collection $serviceViewed
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::aside()
 * @property \Domain\Products\Models\Product\Product[]|\Domain\Products\Collections\ProductCollection $aside
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::orders()
 * @property \Domain\Orders\Models\Order[]|\Illuminate\Database\Eloquent\Collection $orders
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getCartNotTrashedAttribute()
 * @property \Domain\Products\Collections\ProductCollection|Product[] $cart_not_trashed
 *
 * @method static static|\Domain\Users\QueryBuilders\UserQueryBuilder query()
 *
 * @mixin \Domain\Common\Models\BaseModel
 * */
class BaseUser extends Authenticatable implements MustVerifyEmail
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

    public function getIsAdminAttribute(): bool
    {
        return $this->status >= static::ADMIN_THRESHOLD;
    }

    public function getIsSuperAdminAttribute(): bool
    {
        return $this->status >= static::SUPER_ADMIN;
    }

    public function getIsIdentifiedAttribute(): bool
    {
        return !empty($this->email);
    }

    public function getIsAnonymous2Attribute(): bool
    {
        return empty($this->email);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserCart::TABLE)->using(ProductUserCart::class)->as('cart_product')->withPivot(["count", "created_at", "deleted_at"])->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function viewed(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserViewed::TABLE)->using(ProductUserViewed::class)->as('viewed_product')->withPivot(["created_at"])->withTimestamps();
    }

    public function serviceViewed(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, ServiceUserViewed::TABLE)->using(ServiceUserViewed::class)->as('viewed_service')->withPivot(['created_at'])->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
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
        return $this->cart->cartProductsNotTrashed();
    }
}
