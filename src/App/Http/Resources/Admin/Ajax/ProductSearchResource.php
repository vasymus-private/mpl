<?php

namespace App\Http\Resources\Admin\Ajax;

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
            'name' => $this->resource->name,
            'uuid' => $this->resource->uuid,
            'image' => $this->resource->main_image_md_thumb_url,
            'price_rub_formatted' => $this->resource->price_retail_rub_formatted,
        ];
    }
}
