<?php

namespace Domain\Products\Collections;

use Domain\Products\Models\Product\Product;
use Support\H;
use Domain\Common\Models\Currency;
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

    public function cartProductsNotTrashed(): self
    {
        return $this->filter(function(Product $product) {
            return ($product->cart_product->deleted_at ?? null) === null;
        });
    }

    public function orderProductsSumRetailPriceRub(): float
    {
        return $this->reduce(function(float $acc, Product $product) {
            $priceRetailRub = $product->order_product_price_retail_rub_sum;
            return $acc + $priceRetailRub;
        }, 0.0);
    }

    public function orderProductsSumRetailPriceRubFormatted(): string
    {
        return H::priceRubFormatted($this->orderProductsSumRetailPriceRub(), Currency::ID_RUB);
    }

    public function orderProductsCount(): int
    {
        return $this->reduce(function(int $acc, Product $product) {
            return $acc + $product->order_product_count;
        }, 0);
    }
}