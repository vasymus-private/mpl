<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_1_id
 * @property int $product_2_id
 * @property int $type
 * */
class ProductProduct extends Pivot
{
    const TABLE = "product_product";

    const TYPE_ACCESSORY = 1;
    const TYPE_SIMILAR = 2;
    const TYPE_RELATED = 3;
    const TYPE_WORK = 4;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
