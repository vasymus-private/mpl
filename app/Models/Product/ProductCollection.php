<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Collection;

class ProductCollection extends Collection
{
    public function pivotNotTrashed(): self
    {
        return $this->filter(function(Product $product) {
            return ($product->pivot->deleted_at ?? null) === null;
        });
    }
}
