<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Product\Product;

class DeleteProductAction extends BaseAction
{
    public function execute(Product $product)
    {
        $product->variations->each(function (Product $variation) {
            static::cached()->execute($variation);
        });

        $product->deleted_item_slug = $product->slug;
        $product->slug = null;
        $product->save();

        $product->delete();
    }
}
