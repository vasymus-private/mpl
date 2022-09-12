<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use Domain\Products\Actions\CreateOrUpdateProduct\CreateOrUpdateProductAction;
use Domain\Products\Models\Product\Product;

class ProductsController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateProductRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateProduct\CreateOrUpdateProductAction $createOrUpdateProductAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateUpdateProductRequest $request, CreateOrUpdateProductAction $createOrUpdateProductAction)
    {
        $product = $createOrUpdateProductAction->execute($request->prepare());
        $product->setRelations([]);

        return new ProductResource(
            Product::query()->findOrFail($product->id)
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateProductRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateProduct\CreateOrUpdateProductAction $createOrUpdateProductAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CreateUpdateProductRequest $request, CreateOrUpdateProductAction $createOrUpdateProductAction)
    {
        /** @var \Domain\Products\Models\Product\Product $target */
        $target = $request->admin_product;

        $product = $createOrUpdateProductAction->execute($request->prepare(), $target);
        $product->setRelations([]);

        return new ProductResource(
            Product::query()->findOrFail($product->id)
        );
    }
}
