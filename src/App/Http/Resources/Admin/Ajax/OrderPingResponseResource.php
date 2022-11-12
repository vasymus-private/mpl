<?php

namespace App\Http\Resources\Admin\Ajax;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderPingResponseResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Orders\Models\Order
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
            'uuid' => $this->resource->uuid,
            'busy_by_id' => $this->resource->busy_by_id,
            'busy_at' => $this->resource->busy_at,
            'is_busy_by_other_admin' => $this->resource->is_busy_by_other_admin,
        ];
    }
}
