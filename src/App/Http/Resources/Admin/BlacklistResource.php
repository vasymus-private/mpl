<?php

namespace App\Http\Resources\Admin;

use App\Http\Controllers\Admin\IpResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BlacklistResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Users\Models\Blacklist
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
            'ipDetails' => $this->resource->ipDetails
                ? (new IpResource($this->resource->ipDetails))->toArray($request)
                : null,
            'email' => $this->resource->email,
            'ip' => $this->resource->ip,
            'created_at' => $this->resource->created_at instanceof Carbon
                ? $this->resource->created_at->format('Y-m-d H:i:s')
                : null,
        ];
    }
}
