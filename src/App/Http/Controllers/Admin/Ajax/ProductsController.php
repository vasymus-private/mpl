<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateProductRequest;
use App\Http\Requests\Admin\Ajax\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use Domain\Products\Actions\CreateOrUpdateProductAction;
use Domain\Products\Models\Product\Product;

class ProductsController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateProductRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateProductAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateProductRequest $request, CreateOrUpdateProductAction $createOrUpdateProductAction)
    {
        $product = $createOrUpdateProductAction->execute($request->prepare());

        return new ProductResource(
            Product::query()->findOrFail($product->id)
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\UpdateProductRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateProductAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(UpdateProductRequest $request, CreateOrUpdateProductAction $createOrUpdateProductAction)
    {
        /** @var \Domain\Products\Models\Product\Product $target */
        $target = $request->admin_product;

        $product = $createOrUpdateProductAction->execute($request->prepare(), $target);

        return new ProductResource(
            Product::query()->findOrFail($product->id)
        );
    }
}
