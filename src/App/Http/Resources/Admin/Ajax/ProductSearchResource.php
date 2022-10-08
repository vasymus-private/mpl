<?php

namespace App\Http\Resources\Admin\Ajax;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchResource extends JsonResource
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
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'parent_id' => null,
            'uuid' => $this->resource->uuid,
            'is_active' => $this->resource->is_active,
            'name' => $this->resource->name,
            'image' => $this->resource->main_image_md_thumb_url,
            'price_rub_formatted' => $this->resource->price_retail_rub_formatted,
            'is_with_variations' => $this->resource->is_with_variations,
            'unit' => $this->resource->unit,
            'price_purchase' => $this->resource->price_purchase,
            'price_purchase_currency_id' => $this->resource->price_purchase_currency_id,
            'price_retail' => $this->resource->price_retail,
            'price_retail_currency_id' => $this->resource->price_retail_currency_id,
            'ordering' => $this->resource->ordering,
            'variations' => $this->resource->variations->map(fn (Product $variation) => [
                'id' => $variation->id,
                'parent_id' => $this->resource->parent_id,
                'uuid' => $variation->uuid,
                'is_active' => $variation->is_active,
                'name' => $variation->name,
                'image' => $variation->main_image_md_thumb_url,
                'price_rub_formatted' => $variation->price_retail_rub_formatted,
                'is_with_variations' => false,
                'unit' => $variation->unit,
                'price_purchase' => $variation->price_purchase,
                'price_purchase_currency_id' => $variation->price_purchase_currency_id,
                'price_retail' => $variation->price_retail,
                'price_retail_currency_id' => $variation->price_retail_currency_id,
                'ordering' => $variation->ordering,
            ]),
        ];
    }
}
