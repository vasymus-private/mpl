<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $category_id
 * @property int $product_id
 * */
class CategoryProduct extends Pivot
{

}
