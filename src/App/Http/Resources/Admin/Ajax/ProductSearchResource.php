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
            'uuid' => $this->resource->uuid,
            'is_active' => $this->resource->is_active,
            'name' => $this->resource->name,
            'image' => $this->resource->main_image_md_thumb_url,
            'price_rub_formatted' => $this->resource->price_retail_rub_formatted,
            'is_with_variations' => $this->resource->is_with_variations,
            'variations' => $this->resource->variations->map(fn (Product $variation) => [
                'id' => $variation->id,
                'uuid' => $variation->uuid,
                'is_active' => $this->resource->is_active,
                'name' => $variation->name,
                'image' => $variation->main_image_md_thumb_url,
                'price_rub_formatted' => $variation->price_retail_rub_formatted,
                'is_with_variations' => false,
            ]),
        ];
    }
}
