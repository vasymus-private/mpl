<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\DB;

class DeleteBrandAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Brand $brand
     *
     * @return void
     */
    public function execute(Brand $brand)
    {
        DB::transaction(function() use($brand) {
            $brand->products->each(function(Product $product) {
                $product->brand_id = null;
                $product->save();
            });

            $brand->delete();
        });
    }
}
