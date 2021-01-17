<?php

namespace App\Models\Product;

use App\H;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class ProductCollection extends Collection
{
    public function pivotNotTrashed(): self
    {
        return $this->filter(function(Product $product) {
            return ($product->pivot->deleted_at ?? null) === null;
        });
    }

    public function pivotSumRetailRubPrice(): float
    {
        return $this->reduce(function(float $acc, Product $product) {
            $priceRetailRub = $product->pivot_price_retail_rub_sum;
            return $acc + $priceRetailRub;
        }, 0.0);
    }

    public function pivotSumRetailRubPriceFormatted(): string
    {
        return H::priceRubFormatted($this->pivotSumRetailRubPrice(), Currency::ID_RUB);
    }
}
