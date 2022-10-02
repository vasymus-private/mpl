<?php

namespace Domain\Orders\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $order_id
 * @property int $ordering
 * @property int $count
 * @property string $name
 * @property string $unit
 * @property float $price_retail_rub
 * @property float $price_retail_rub_origin
 * @property bool $price_retail_rub_was_updated
 * */
class OrderProduct extends Pivot
{
    public const TABLE = "order_product";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    protected $casts = [
        'price_retail_rub_was_updated' => 'bool',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'count' => 1,
        'ordering' => 0,
        'price_retail_rub_was_updated' => false,
    ];
}
