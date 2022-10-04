<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandItemResource extends JsonResource
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'ordering' => $this->resource->ordering,
            'preview' => $this->resource->preview,
        ];
    }
}
