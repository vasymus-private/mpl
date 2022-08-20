<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateProductRequest;
use App\Http\Requests\Admin\Ajax\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use Domain\Products\Models\Product\Product;

class ProductsController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateProductRequest $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateProductRequest $request)
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = $request->admin_product;

        return new ProductResource(
            Product::query()->findOrFail($product->id)
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\UpdateProductRequest $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(UpdateProductRequest $request)
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = $request->admin_product;

        if ($request->has('name')) {
            $product->name = $request->name;
        }

        if ($request->has('slug')) {
            $product->slug = $request->slug;
        }

        if ($request->has('ordering')) {
            $product->ordering = $request->ordering;
        }

        if ($request->has('is_active')) {
            $product->is_active = $request->is_active;
        }

        if ($request->has('unit')) {
            $product->unit = $request->unit;
        }

        if ($request->has('price_purchase')) {
            $product->price_purchase = $request->price_purchase;
        }

        if ($request->has('price_purchase_currency_id')) {
            $product->price_purchase_currency_id = $request->price_purchase_currency_id;
        }

        if ($request->has('price_retail')) {
            $product->price_retail = $request->price_retail;
        }

        if ($request->has('price_retail_currency_id')) {
            $product->price_retail_currency_id = $request->price_retail_currency_id;
        }

        if ($request->has('admin_comment')) {
            $product->admin_comment = $request->admin_comment;
        }

        if ($request->has('availability_status_id')) {
            $product->availability_status_id = $request->availability_status_id;
        }

        if ($request->has('parent_id')) {
            $product->parent_id = $request->parent_id;
        }

        if ($request->has('brand_id')) {
            $product->brand_id = $request->brand_id;
        }

        if ($request->has('category_id')) {
            $product->category_id = $request->category_id;
        }

        if ($request->has('is_with_variations')) {
            $product->is_with_variations = $request->is_with_variations;
        }

        if ($request->has('coefficient')) {
            $product->coefficient = $request->coefficient;
        }

        if ($request->has('coefficient_description')) {
            $product->coefficient_description = $request->coefficient_description;
        }

        if ($request->has('coefficient_description_show')) {
            $product->coefficient_description_show = $request->coefficient_description_show;
        }

        if ($request->has('coefficient_variation_description')) {
            $product->coefficient_variation_description = $request->coefficient_variation_description;
        }

        if ($request->has('price_name')) {
            $product->price_name = $request->price_name;
        }

        if ($request->has('preview')) {
            $product->preview = $request->preview;
        }

        if ($request->has('description')) {
            $product->description = $request->description;
        }

        if ($request->has('accessory_name')) {
            $product->accessory_name = $request->accessory_name;
        }

        if ($request->has('similar_name')) {
            $product->similar_name = $request->similar_name;
        }

        if ($request->has('related_name')) {
            $product->related_name = $request->related_name;
        }

        if ($request->has('work_name')) {
            $product->work_name = $request->work_name;
        }

        if ($request->has('instruments_name')) {
            $product->instruments_name = $request->instruments_name;
        }

        $product->save();

        return new ProductResource(
            Product::query()->findOrFail($product->id)
        );
    }
}
