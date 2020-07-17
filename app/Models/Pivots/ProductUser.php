<?php

namespace App\Models\Pivots;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $user_id
 * @property int $type_id
 * @property int $count
 * @property Carbon|null $created_at
 * */
class ProductUser extends Pivot
{
    const TABLE = "product_user";

    const TYPE_CART = 1;
    const TYPE_VIEWED = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
