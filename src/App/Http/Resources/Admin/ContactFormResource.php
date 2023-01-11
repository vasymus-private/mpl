<?php

namespace App\Http\Resources\Admin;

use App\Http\Controllers\Admin\IpResource;
use Domain\Common\Models\CustomMedia;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ContactFormResource extends JsonResource
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
            'email' => $this->resource->email,
            'name' => $this->resource->name,
            'phone' => $this->resource->phone,
            'description' => $this->resource->description,
            'ipDetails' => $this->resource->ipDetails
                ? (new IpResource($this->resource->ipDetails))->toArray($request)
                : null,
            'created_at' => $this->resource->created_at instanceof Carbon
                ? $this->resource->created_at->format('Y-m-d H:i:s')
                : null,
            'files' => $this->resource->files->map(fn (CustomMedia $media) => (new MediaResource($media))->toArray($request)),
        ];
    }
}
