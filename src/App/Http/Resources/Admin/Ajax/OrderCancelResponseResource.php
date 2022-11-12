<?php

namespace App\Http\Resources\Admin\Ajax;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderCancelResponseResource extends JsonResource
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
            'cancelled' => $this->resource->cancelled,
            'cancelled_description' => $this->resource->cancelled_description,
            'updated_at' => $this->resource->updated_at instanceof Carbon
                ? $this->resource->updated_at->format('Y-m-d H:i:s')
                : null,
        ];
    }
}
