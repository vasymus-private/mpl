<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $order_id
 * @property int $count
 * @property float $price_purchase
 * @property float $price_retail
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
