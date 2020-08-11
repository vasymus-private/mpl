<?php

namespace App\Models\Pivots;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * */
class ProductUserAside extends Pivot
{
    const TABLE = "product_user_aside";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
