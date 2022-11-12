<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Common\Models\CustomMedia
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
            'url' => $this->resource->getFullUrl(),
            'name' => $this->resource->name,
            'file_name' => $this->resource->file_name,
            'order_column' => $this->resource->order_column,
        ];
    }
}
