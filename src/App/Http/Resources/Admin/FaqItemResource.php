<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqItemResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\FAQs\Models\FAQ
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
        ];
    }
}
