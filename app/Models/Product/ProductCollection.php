<?php

namespace App\Models\Product;

use App\H;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class ProductCollection extends Collection
{
    public function sumCartRetailPriceRub(): float
    {
        return $this
                ->reduce(function(float $acc, Product $product) {
                    $count = $product->cart_product->count ?? 1;
                    $priceRub = $product->price_retail_rub * $count;
                    return $acc + $priceRub;
                }, 0.0)
            ;
    }

    public function cartProductNotTrashed(): self
    {
        return $this->filter(function(Product $product) {
            return ($product->cart_product->deleted_at ?? null) === null;
        });
    }

    public function orderProductSumRetailPriceRub(): float
    {
        return $this->reduce(function(float $acc, Product $product) {
            $priceRetailRub = $product->order_product_price_retail_rub_sum;
            return $acc + $priceRetailRub;
        }, 0.0);
    }

    public function orderProductSumRetailPriceRubFormatted(): string
    {
        return H::priceRubFormatted($this->orderProductSumRetailPriceRub(), Currency::ID_RUB);
    }
}
