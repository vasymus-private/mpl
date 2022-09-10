<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\ProductsBulkRequest;
use App\Http\Resources\Admin\ProductListItemResource;
use Domain\Products\Models\Product\Product;

class ProductsBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\ProductsBulkRequest $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(ProductsBulkRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $productsToUpdate = Product::query()
            ->whereIn('id', $ids)
            ->get();

        $productsToUpdate->each(function (Product $product) use ($payload) {
            $toUpdate = $payload[$product->id];
            $product->forceFill(
                collect($toUpdate->all())
                    ->except('id')
                    ->all()
            );
            $product->save();
        });

        return ProductListItemResource::collection(
            Product::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }
}
