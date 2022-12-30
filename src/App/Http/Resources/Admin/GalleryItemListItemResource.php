<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryItemListItemResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\GalleryItems\Models\GalleryItem
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'uuid' => $this->resource->uuid,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'parent_id' => $this->resource->parent_id,
            'is_active' => $this->resource->is_active,
            'description' => $this->resource->description,
            'seo' => $this->resource->seo,
        ];
    }
}
