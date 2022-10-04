<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderEventResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Orders\Models\OrderEvent
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
            'userName' => $this->resource->user->name ?? null,
            'operation' => $this->resource->type_name,
            'description' => $this->resource->payload['description'] ?? '',
            'created_at' => $this->resource->created_at instanceof Carbon
                ? $this->resource->created_at->format('Y-m-d H:i:s')
                : null,
        ];
    }
}
