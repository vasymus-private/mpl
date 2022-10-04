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
            'preview' => $this->resource->preview,
            'description' => $this->resource->description,
            'seo' => $this->resource->seo,
            'mainImage' => $this->resource->main_image_media
                ? [
                    'id' => $this->resource->main_image_media->id,
                    'uuid' => $this->resource->main_image_media->uuid,
                    'url' => $this->resource->main_image_media->getFullUrl(),
                    'name' => $this->resource->main_image_media->name,
                    'file_name' => $this->resource->main_image_media->file_name,
                ]
                : null,
        ];
    }
}
