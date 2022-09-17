<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemProductItemResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Products\Models\Product\Product
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
            'product' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'unit' => $this->resource->unit,
            ],
            'order_product' => [
                'name' => $this->resource->order_product->name ?? null,
                'unit' => $this->resource->order_product->unit ?? null,
                'count' => $this->resource->order_product->count ?? null,
            ],
        ];
    }
}
