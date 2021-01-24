<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;
use Domain\Common\Models\Currency;
use Domain\Orders\Models\OrderStatus;
use Support\H;
use Domain\Orders\Models\Pivots\OrderProduct;
use Domain\Products\Models\Product\Product;
use Domain\Products\Collections\ProductCollection;
use Domain\Users\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @property int $id
 * @property float $price_retail_rub
 * @property int $order_status_id
 * @property int $user_id
 * @property int $manager_id
 * @property int $importance_id
 * @property int $customer_bill_status_id
 * @property string|null $customer_bill_description
 * @property int $provider_bill_status_id
 * @property string|null $provider_bill_description
 * @property string|null $comment_user
 * @property string|null $comment_manager
 * @property string|null $ps_status
 * @property string|null $ps_description
 * @property float|null $ps_amount
 * @property Carbon|null $ps_date
 * @property int|null $payment_method_id
 * @property string|null $payment_method_description
 * @property array|null $request
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @see Order::products()
 * @property ProductCollection|Product[] $products
 *
 * @see Order::user()
 * @property User $user
 *
 * @see Order::status()
 * @property OrderStatus $status
 *
 * @see Order::getOrderPriceRetailRubAttribute()
 * @property-read float $order_price_retail_rub
 *
 * @see Order::getOrderPriceRetailRubFormattedAttribute()
 * @property-read string $order_price_retail_rub_formatted
 *
 * @see Order::getPriceRetailRubFormattedAttribute()
 * @property-read string $price_retail_rub_formatted
 *
 * @see Order::getStatusNameForUserAttribute()
 * @property-read string $status_name_for_user
 *
 * @see Order::getUserNameAttribute()
 * @property-read string $user_name
 *
 * @see Order::getUserEmailAttribute()
 * @property-read string $user_email
 *
 * @see Order::getUserPhoneAttribute()
 * @property-read string $user_phone
 * */
class Order extends \Domain\Common\Models\BaseModel implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;

    const TABLE = "orders";

    const MC_INITIAL_ATTACHMENT = "initial-attachment";
    const MC_PAYMENT_METHOD_ATTACHMENT = "payment-method-attachment";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ["ps_date"];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'request' => 'array'
    ];

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, OrderProduct::TABLE, "order_id", "product_id")
            ->using(OrderProduct::class)
            ->as('order_product')
            ->withPivot([
                "count",
                "price_purchase",
                "price_purchase_currency_id",
                "price_retail",
                "price_retail_currency_id",
                "name",
            ])
        ;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, "order_status_id", "id");
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection(static::MC_INITIAL_ATTACHMENT);

        $this->addMediaCollection(static::MC_PAYMENT_METHOD_ATTACHMENT);
    }

    public function getOrderPriceRetailRubAttribute(): float
    {
        return $this->products->orderProductSumRetailPriceRub();
    }

    public function getOrderPriceRetailRubFormattedAttribute(): string
    {
        return $this->products->orderProductSumRetailPriceRubFormatted();
    }

    public function getPriceRetailRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->price_retail_rub, \Domain\Common\Models\Currency::ID_RUB);
    }

    public function getStatusNameForUserAttribute(): string
    {
        switch (true) {
            case in_array($this->order_status_id, OrderStatus::IDS_OPEN) : {
                return "Открыт";
            }
            case in_array($this->order_status_id, OrderStatus::IDS_PAYED) : {
                return "Оплачен";
            }
            default : {
                return "Закрыт";
            }
        }
    }

    public function getUserNameAttribute(): string
    {
        return !empty($this->user->name)
                ? $this->user->name
                : (
                $this->request["name"] ?? ""
            )
        ;
    }

    public function getUserEmailAttribute(): string
    {
        return !empty($this->user->email)
                ? $this->user->email
                : (
                $this->request["email"] ?? ""
            )
        ;
    }

    public function getUserPhoneAttribute(): string
    {
        return !empty($this->user->phone)
            ? $this->user->phone
            : (
                $this->request["phone"] ?? ""
            )
            ;
    }
}
