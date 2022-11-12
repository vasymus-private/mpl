<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\ProductsBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\ProductsBulkUpdateRequest;
use App\Http\Resources\Admin\ProductListItemResource;
use Domain\Products\Actions\DeleteProductAction;
use Domain\Products\Actions\DeleteVariationAction;
use Domain\Products\Models\Product\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductsBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\ProductsBulkUpdateRequest $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(ProductsBulkUpdateRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $productsToUpdate = Product::query()
            ->whereIn('id', $ids)
            ->get();

        $productsToUpdate->each(function (Product $product) use ($payload) {
            $toUpdate = $payload[$product->id];

            $toFill = collect($toUpdate->all())
                ->except(['id', 'relatedCategoriesIds'])
                ->all();
            $product->forceFill($toFill);

            $product->save();
            $product->relatedCategories()->sync($payload[$product->id]->relatedCategoriesIds);
        });

        return ProductListItemResource::collection(
            Product::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\ProductsBulkDeleteRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(ProductsBulkDeleteRequest $request)
    {
        /** @var \Domain\Products\Collections\ProductCollection $products */
        $products = Product::query()->notVariations()->with('variations')->whereIn('id', $request->ids)->get();

        /** @var \Domain\Products\Collections\ProductCollection $products */
        $variations = Product::query()->variations()->whereIn('id', $request->ids)->get();

        $products->each(function (Product $product) {
            DeleteProductAction::cached()->execute($product);
        });

        $variations->each(function (Product $variation) {
            DeleteVariationAction::cached()->execute($variation);
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}
