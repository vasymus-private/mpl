<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductItemResource extends JsonResource
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
                'uuid' => $this->resource->uuid,
                'name' => $this->resource->name,
                'unit' => $this->resource->unit,
                'price_purchase' => $this->resource->price_purchase,
                'price_purchase_currency_id' => $this->resource->price_purchase_currency_id,
                'price_retail' => $this->resource->price_retail,
                'price_retail_currency_id' => $this->resource->price_retail_currency_id,
                'coefficient' => $this->resource->coefficient,
                'availability_status_id' => $this->resource->availability_status_id,
                'mainImage' => $this->resource->main_image_media
                    ? new MediaResource($this->resource->main_image_media)
                    : null,
            ],
            'order_product' => [
                'count' => $this->resource->order_product->count ?? 1,
                'name' => $this->resource->order_product->name ?? null,
                'unit' => $this->resource->order_product->unit ?? null,
                'price_purchase' => $this->resource->order_product->price_purchase ?? null,
                'price_purchase_currency_id' => $this->resource->order_product->price_purchase_currency_id ?? null,
                'price_retail' => $this->resource->order_product->price_retail ?? null,
                'price_retail_currency_id' => $this->resource->order_product->price_retail_currency_id ?? null,
                'ordering' => $this->resource->order_product->ordering ?? null,
                'price_retail_rub' => $this->resource->order_product->price_retail_rub ?? null,
                'price_retail_rub_origin' => $this->resource->order_product->price_retail_rub_origin ?? null,
                'price_retail_rub_was_updated' => $this->resource->order_product->price_retail_rub_was_updated ?? null,
            ],
        ];
    }
}
