<?php

namespace Domain\Orders\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $order_id
 * @property int $count
 * @property float $price_purchase
 * @property int $price_purchase_currency_id
 * @property float $price_retail
 * @property int $price_retail_currency_id
 * @property string|null $name
 * @property string|null $unit
 * @property float $price_retail_rub
 * @property float $price_retail_rub_origin
 * @property bool $price_retail_rub_was_updated
 * */
class OrderProduct extends Pivot
{
    const TABLE = "order_product";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    protected $casts = [
        'price_retail_rub_was_updated' => 'bool',
    ];
}
