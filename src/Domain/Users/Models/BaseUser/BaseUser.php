<?php

namespace Domain\Users\Models\BaseUser;

use Domain\Common\Enums\Column;
use Domain\Common\Models\CommonTraits;
use Domain\Orders\Actions\GetDefaultAdminOrderColumnsAction;
use Domain\Orders\Models\Order;
use Domain\Products\Actions\GetDefaultAdminProductColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductVariantColumnsAction;
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
 * @property string|null $phone
 *
 * @property string|null $password
 * @property string|null $remember_token
 *
 * @property int $status
 * @property string|null $admin_color
 *
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property \Carbon\Carbon|null $email_verified_at
 *
 * @property array $settings
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
 * @see \Domain\Users\Models\BaseUser\BaseUser::getAdminOrderColumnsAttribute()
 * @see \Domain\Users\Models\BaseUser\BaseUser::setAdminOrderColumnsAttribute()
 * @property \Domain\Common\Enums\Column[] $admin_order_columns
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getAdminOrderColumnsArrAttribute()
 * @property-read array[] $admin_order_columns_arr
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getAdminProductColumnsAttribute()
 * @see \Domain\Users\Models\BaseUser\BaseUser::setAdminProductColumnsAttribute()
 * @property \Domain\Common\Enums\Column[] $admin_product_columns
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getAdminProductColumnsArrAttribute()
 * @property-read array[] $admin_product_columns_arr
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getAdminProductVariantColumnsAttribute()
 * @see \Domain\Users\Models\BaseUser\BaseUser::setAdminProductVariantColumnsAttribute()
 * @property \Domain\Common\Enums\Column[] $admin_product_variant_columns
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::getAdminProductVariantColumnsArrAttribute()
 * @property-read array[] $admin_product_variant_columns_arr
 *
 * @method static \Domain\Users\QueryBuilders\UserQueryBuilder query()
 *
 * @property-read int $viewed_count
 * @property-read int $service_viewed_count
 *
 * @mixin \Domain\Common\Models\BaseModel
 * */
class BaseUser extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use CommonTraits;

    public const TABLE = "users";

    public const ADMIN_THRESHOLD = 5;
    public const SUPER_ADMIN = 10;

    protected const SETTINGS_ADMIN_ORDER_COLUMNS = 'adminOrderColumns';
    protected const SETTINGS_ADMIN_PRODUCT_COLUMNS = 'adminProductColumns';
    protected const SETTINGS_ADMIN_PRODUCT_VARIANT_COLUMNS = 'adminProductVariantColumns';

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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'settings' => '[]',
    ];

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     *
     * @return \Domain\Users\QueryBuilders\UserQueryBuilder<\Domain\Users\Models\BaseUser\BaseUser>
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
        return ! empty($this->email);
    }

    public function getIsAnonymous2Attribute(): bool
    {
        return empty($this->email);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserCart::TABLE, 'user_id', 'product_id')
            ->using(ProductUserCart::class)
            ->as('cart_product')
            ->withPivot(["count", "created_at", "deleted_at"])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function viewed(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserViewed::TABLE, 'user_id', 'product_id')
            ->using(ProductUserViewed::class)
            ->as('viewed_product')
            ->withPivot(["created_at"])
            ->withTimestamps();
    }

    public function serviceViewed(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, ServiceUserViewed::TABLE, 'user_id', 'service_id')
            ->using(ServiceUserViewed::class)
            ->as('viewed_service')
            ->withPivot(['created_at'])->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function aside(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductUserAside::TABLE, 'user_id', 'product_id')
            ->using(ProductUserAside::class)
            ->as('aside_product')
            ->withPivot(["created_at"])
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "user_id", "id");
    }

    public function getCartNotTrashedAttribute(): Collection
    {
        return $this->cart->cartProductsNotTrashed();
    }

    /**
     * @return \Domain\Common\Enums\Column[]
     */
    public function getAdminOrderColumnsAttribute(): array
    {
        $settings = $this->settings;
        $adminOrderColumns = $settings[static::SETTINGS_ADMIN_ORDER_COLUMNS] ?? GetDefaultAdminOrderColumnsAction::cached()->execute();

        return collect($adminOrderColumns)->unique()->values()->map(fn ($value) => Column::from($value))->all();
    }

    /**
     * @param \Domain\Common\Enums\Column[] $adminOrderColumns
     *
     * @return void
     */
    public function setAdminOrderColumnsAttribute(array $adminOrderColumns): void
    {
        $settings = $this->settings;
        $settings[static::SETTINGS_ADMIN_ORDER_COLUMNS] = collect($adminOrderColumns)->map(fn (Column $orderAdminColumn) => $orderAdminColumn->value)->all();
        $this->settings = $settings;
    }

    /**
     * @return \Domain\Common\Enums\Column[]
     */
    public function getAdminProductColumnsAttribute(): array
    {
        $settings = $this->settings;
        $adminProductColumns = $settings[static::SETTINGS_ADMIN_PRODUCT_COLUMNS] ?? GetDefaultAdminProductColumnsAction::cached()->execute();

        return collect($adminProductColumns)->unique()->values()->map(fn ($value) => Column::from($value))->all();
    }

    /**
     * @param \Domain\Common\Enums\Column[] $adminProductColumns
     *
     * @return void
     */
    public function setAdminProductColumnsAttribute(array $adminProductColumns): void
    {
        $settings = $this->settings;
        $settings[static::SETTINGS_ADMIN_PRODUCT_COLUMNS] = collect($adminProductColumns)->map(fn (Column $productAdminColumn) => $productAdminColumn->value)->all();
        $this->settings = $settings;
    }

    /**
     * @return \Domain\Common\Enums\Column[]
     */
    public function getAdminProductVariantColumnsAttribute(): array
    {
        $settings = $this->settings;
        $adminProductVariantColumns = $settings[static::SETTINGS_ADMIN_PRODUCT_VARIANT_COLUMNS] ?? GetDefaultAdminProductVariantColumnsAction::cached()->execute();

        return collect($adminProductVariantColumns)->unique()->values()->map(fn ($value) => Column::from($value))->all();
    }

    /**
     * @param \Domain\Common\Enums\Column[] $adminProductVariantColumns
     *
     * @return void
     */
    public function setAdminProductVariantColumnsAttribute(array $adminProductVariantColumns): void
    {
        $settings = $this->settings;
        $settings[static::SETTINGS_ADMIN_PRODUCT_VARIANT_COLUMNS] = collect($adminProductVariantColumns)->map(fn (Column $productVariantAdminColumn) => $productVariantAdminColumn->value)->all();
        $this->settings = $settings;
    }

    /**
     * @return array[]
     * @phpstan-return array<array<int|string>>
     */
    public function getAdminOrderColumnsArrAttribute(): array
    {
        return collect($this->admin_order_columns)->map([static::class, '_columnsMapCB'])->all();
    }

    /**
     * @return array[]
     * @phpstan-return array<array<int|string>>
     */
    public function getAdminProductColumnsArrAttribute(): array
    {
        return collect($this->admin_product_columns)->map([static::class, '_columnsMapCB'])->all();
    }

    /**
     * @return array[]
     * @phpstan-return array<array<int|string>>
     */
    public function getAdminProductVariantColumnsArrAttribute(): array
    {
        return collect($this->admin_product_variant_columns)->map([static::class, '_columnsMapCB'])->all();
    }

    /**
     * @param \Domain\Common\Enums\Column $column
     *
     * @return array
     * @phpstan-return array<int|string>
     */
    public static function _columnsMapCB(Column $column): array
    {
        return [
            'value' => $column->value,
            'label' => $column->label,
        ];
    }
}
