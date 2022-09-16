<?php

namespace App\Http\Resources\Admin;

use Domain\Common\Models\Currency;
use Illuminate\Http\Resources\Json\JsonResource;
use Support\H;

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
            'id' => $this->resource->id,
            'uuid' => $this->resource->uuid,
            'coefficient' => $this->resource->coefficient,
            'availability_status_id' => $this->resource->availability_status_id,
            'image' => $this->resource->main_image_media
                ? new MediaResource($this->resource->main_image_media)
                : null,

            'price_purchase' => $this->resource->price_purchase,
            'price_purchase_currency_id' => $this->resource->price_purchase_currency_id,
            'price_retail' => $this->resource->price_retail,
            'price_retail_currency_id' => $this->resource->price_retail_currency_id,

            'order_product' => $this->resource->order_product,

            // order product and calculated props
            'name' => $this->resource->order_product->name ?? $this->resource->name,
            'order_product_count' => $this->resource->order_product_count,
            'unit' => $this->resource->order_product->unit ?? $this->resource->unit,
            'ordering' => $this->resource->order_product->ordering ?: $this->resource->id,
            'order_product_price_purchase_rub_sum' => $this->resource->order_product_price_purchase_rub_sum,
            'order_product_price_purchase_rub_sum_formatted' => $this->resource->order_product_price_purchase_rub_sum_formatted,
            'order_product_price_retail_rub' => $this->resource->order_product_price_retail_rub,
            'order_product_price_retail_rub_formatted' => $this->resource->order_product_price_retail_rub_formatted,
            'order_product_price_retail_rub_sum' => $this->resource->order_product_price_retail_rub_sum,
            'order_product_price_retail_rub_sum_formatted' => $this->resource->order_product_price_retail_rub_sum_formatted,
            'order_product_diff_rub_price_retail_sum_price_purchase_sum_formatted' => H::priceRubFormatted($this->resource->order_product_price_retail_rub_sum - $this->resource->order_product_price_purchase_rub_sum, Currency::ID_RUB),
            'order_product_price_retail_rub_origin' => $this->resource->order_product_price_retail_rub_origin,
            'order_product_price_retail_rub_origin_formatted' => H::priceRubFormatted($this->resource->order_product_price_retail_rub_origin, Currency::ID_RUB),
            'order_product_price_retail_rub_was_updated' => $this->resource->order_product_price_retail_rub_was_updated,
        ];
    }
}
