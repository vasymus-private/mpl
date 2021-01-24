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
}
