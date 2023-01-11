<?php

namespace App\Http\Resources\Admin;

use App\Http\Controllers\Admin\IpResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactFormItemResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Users\Models\ContactForm
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
            'type' => $this->resource->type,
            'type_name' => $this->resource->type_name,
            'ipDetails' => $this->resource->ipDetails
                ? (new IpResource($this->resource->ipDetails))->toArray($request)
                : null,
            'email' => $this->resource->email,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
        ];
    }
}
