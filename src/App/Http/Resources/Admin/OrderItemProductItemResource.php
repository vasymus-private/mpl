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
            'id' => $this->resource->id,
            'order_product' => $this->resource->order_product,
            'product_name' => $this->resource->name,
            'unit' => $this->resource->unit,
        ];
    }
}
