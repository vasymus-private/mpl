<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class IpResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Ip\Models\Ip
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
            'ip' => $this->resource->ip,
            'country_a2' => $this->resource->country_a2,
            'country_name' => $this->resource->country_name,
            'country_img' => $this->resource->country_img,
            'city' => $this->resource->city,
            'in_blacklist' => $this->resource->in_blacklist,
        ];
    }
}
