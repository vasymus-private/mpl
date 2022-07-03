<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityStatusResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Products\Models\AvailabilityStatus
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
            'formatted_short_name' => $this->resource->formatted_short_name,
        ];
    }
}
