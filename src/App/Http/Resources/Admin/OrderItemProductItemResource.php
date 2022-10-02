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
            'uuid' => $this->resource->uuid,
            'name' => $this->resource->name,
            'unit' => $this->resource->unit,
            'order_product_name' => $this->resource->order_product->name ?? null,
            'order_product_unit' => $this->resource->order_product->unit ?? null,
            'order_product_count' => $this->resource->order_product->count ?? null,
            'order_product_price_retail_rub' => $this->resource->order_product->price_retail_rub ?? null,
        ];
    }
}
