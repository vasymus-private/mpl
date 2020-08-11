<?php

namespace App\Models\Pivots;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $user_id
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * */
class ProductUserCart extends Pivot
{
    const TABLE = "product_user_cart";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
