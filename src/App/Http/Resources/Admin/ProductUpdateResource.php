<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductUpdateResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Products\Models\Product\Product
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request|\App\Http\Requests\Admin\Ajax\UpdateProductsRequest $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->when($request->has('name'), fn() => $this->resource->name),
            'slug' => $this->when($request->has('slug'), fn() => $this->resource->slug),
            'ordering' => $this->when($request->has('ordering'), fn() => $this->resource->ordering),
            'is_active' => $this->when($request->has('is_active'), fn() => $this->resource->is_active),
            'unit' => $this->when($request->has('unit'), fn() => $this->resource->unit),
            'price_purchase' => $this->when($request->has('price_purchase'), fn() => $this->resource->price_purchase),
            'price_purchase_currency_id' => $this->when($request->has('price_purchase_currency_id'), fn() => $this->resource->price_purchase_currency_id),
            'price_retail' => $this->when($request->has('price_retail'), fn() => $this->resource->price_retail),
            'price_retail_currency_id' => $this->when($request->has('price_retail_currency_id'), fn() => $this->resource->price_retail_currency_id),
            'admin_comment' => $this->when($request->has('admin_comment'), fn() => $this->resource->admin_comment),
            'availability_status_id' => $this->when($request->has('availability_status_id'), fn() => $this->resource->availability_status_id),
            'parent_id' => $this->when($request->has('parent_id'), fn() => $this->resource->parent_id),
            'brand_id' => $this->when($request->has('brand_id'), fn() => $this->resource->brand_id),
            'category_id' => $this->when($request->has('category_id'), fn() => $this->resource->category_id),
            'is_with_variations' => $this->when($request->has('is_with_variations'), fn() => $this->resource->is_with_variations),
            'coefficient' => $this->when($request->has('coefficient'), fn() => $this->resource->coefficient),
            'coefficient_description' => $this->when($request->has('coefficient_description'), fn() => $this->resource->coefficient_description),
            'coefficient_description_show' => $this->when($request->has('coefficient_description_show'), fn() => $this->resource->coefficient_description_show),
            'coefficient_variation_description' => $this->when($request->has('coefficient_variation_description'), fn() => $this->resource->coefficient_variation_description),
            'price_name' => $this->when($request->has('price_name'), fn() => $this->resource->price_name),
            'preview' => $this->when($request->has('preview'), fn() => $this->resource->preview),
            'description' => $this->when($request->has('description'), fn() => $this->resource->description),
            'accessory_name' => $this->when($request->has('accessory_name'), fn() => $this->resource->accessory_name),
            'similar_name' => $this->when($request->has('similar_name'), fn() => $this->resource->similar_name),
            'related_name' => $this->when($request->has('related_name'), fn() => $this->resource->related_name),
            'work_name' => $this->when($request->has('work_name'), fn() => $this->resource->work_name),
            'instruments_name' => $this->when($request->has('instruments_name'), fn() => $this->resource->instruments_name),
        ];
    }
}
