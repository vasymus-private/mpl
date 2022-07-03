<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductListItemResource extends JsonResource
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
            'ordering' => $this->resource->ordering,
            'is_active' => $this->resource->is_active,
            'unit' => $this->resource->unit,
            'price_purchase' => $this->resource->price_purchase,
            'price_purchase_currency_id' => $this->resource->price_purchase_currency_id,
            'price_retail' => $this->resource->price_retail,
            'price_retail_currency_id' => $this->resource->price_retail_currency_id,
            'admin_comment' => $this->resource->admin_comment,
            'availability_status_id' => $this->resource->availability_status_id,
            'brand_id' => $this->resource->brand_id,
        ];
    }
}
