<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;
use Domain\Common\Models\Currency;
use Domain\Users\Models\BaseUser\BaseUser;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Support\H;
use Domain\Orders\Models\Pivots\OrderProduct;
use Domain\Products\Models\Product\Product;
use Domain\Products\Collections\ProductCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
 * @property \Carbon\Carbon|null $ps_date
 * @property int|null $payment_method_id
 * @property string|null $payment_method_description
 * @property array|null $request
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @see \Domain\Orders\Models\Order::products()
 * @property ProductCollection|Product[] $products
 *
 * @see \Domain\Orders\Models\Order::user()
 * @property \Domain\Users\Models\BaseUser\BaseUser $user
 *
 * @see \Domain\Orders\Models\Order::status()
 * @property OrderStatus $status
 *
 * @see \Domain\Orders\Models\Order::getOrderPriceRetailRubAttribute()
 * @property-read float $order_price_retail_rub
 *
 * @see \Domain\Orders\Models\Order::getOrderPriceRetailRubFormattedAttribute()
 * @property-read string $order_price_retail_rub_formatted
 *
 * @see \Domain\Orders\Models\Order::getOrderProductsCountAttribute()
 * @property-read int $order_products_count
 *
 * @see \Domain\Orders\Models\Order::getPriceRetailRubFormattedAttribute()
 * @property-read string $price_retail_rub_formatted
 *
 * @see \Domain\Orders\Models\Order::getStatusNameForUserAttribute()
 * @property-read string $status_name_for_user
 *
 * @see \Domain\Orders\Models\Order::getUserNameAttribute()
 * @property-read string $user_name
 *
 * @see \Domain\Orders\Models\Order::getUserEmailAttribute()
 * @property-read string $user_email
 *
 * @see \Domain\Orders\Models\Order::getUserPhoneAttribute()
 * @property-read string $user_phone
 *
 * @see \Domain\Orders\Models\Order::getIsIndividualAttribute()
 * @property-read bool $is_individual
 *
 * @see \Domain\Orders\Models\Order::getIsBusinessAttribute()
 * @property-read bool $is_business
 *
 * @see \Domain\Orders\Models\Order::getPaymentTypeLegalEntityNameAttribute()
 * @property-read string $payment_type_legal_entity_name
 *
 * @see \Domain\Orders\Models\Order::getInitialAttachmentsAttribute()
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $initial_attachments
 * */
class Order extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Domain\Products\QueryBuilders\ProductQueryBuilder
     */
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
        return $this->belongsTo(BaseUser::class, "user_id", "id");
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, "order_status_id", "id");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_INITIAL_ATTACHMENT)->useDisk('private-media');

        $this->addMediaCollection(static::MC_PAYMENT_METHOD_ATTACHMENT)->useDisk('private-media');
    }

    public function getOrderPriceRetailRubAttribute(): float
    {
        return $this->products->orderProductsSumRetailPriceRub();
    }

    public function getOrderPriceRetailRubFormattedAttribute(): string
    {
        return $this->products->orderProductsSumRetailPriceRubFormatted();
    }

    public function getOrderProductsCountAttribute(): int
    {
        return $this->products->orderProductsCount();
    }

    public function getPriceRetailRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->price_retail_rub, Currency::ID_RUB);
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

    public function getIsIndividualAttribute(): bool
    {
        return in_array($this->payment_method_id, [PaymentMethod::ID_BANK_CARD, PaymentMethod::ID_CASH, PaymentMethod::ID_SBERBANK_INVOICE]);
    }

    public function getIsBusinessAttribute(): bool
    {
        return $this->payment_method_id === PaymentMethod::ID_CASHLESS_FROM_ACCOUNT;
    }

    public function getPaymentTypeLegalEntityNameAttribute(): string
    {
        return $this->is_individual
                ? "Физическое лицо"
                : (
                    $this->is_business
                        ? "Юридическое лицо"
                        : ""
            );
    }

    /**
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[]
     * */
    public function getInitialAttachmentsAttribute(): MediaCollection
    {
        return $this->getMedia(static::MC_INITIAL_ATTACHMENT);
    }
}
