<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\ProductsBulkRequest;
use App\Http\Resources\Admin\ProductListItemResource;
use Domain\Products\DTOs\Admin\ProductListUpdateDTO;
use Domain\Products\Models\Product\Product;

class ProductsBulkController extends BaseAdminController
{
    public function update(ProductsBulkRequest $request)
    {
        $payload = $request->productsPayload();
        $ids = collect($payload)->map(fn (ProductListUpdateDTO $item) => $item->id)->toArray();

        $productsToUpdate = Product::query()
            ->whereIn('id', $ids)
            ->get();

        $productsToUpdate->each(function (Product $product) use ($payload) {
            $toUpdate = $payload[$product->id];
            $product->name = $toUpdate->name;
            $product->save();
        });

        return ProductListItemResource::collection(
            Product::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }
}
