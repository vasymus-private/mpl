<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Products\Models\Brand
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
            'slug' => $this->resource->slug,
            'ordering' => $this->resource->ordering,
            'description' => $this->resource->description,
            'seo' => $this->resource->seo,
        ];
    }
}
