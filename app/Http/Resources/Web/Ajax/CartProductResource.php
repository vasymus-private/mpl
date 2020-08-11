<?php

namespace App\Http\Resources\Web\Ajax;

use App\Models\Currency;
use App\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Product
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            "mainImage" => $this->resource->getFirstMediaUrl(Product::MC_MAIN_IMAGE),
            "price_rub" => $this->resource->price_retail_rub,
            "currency_rub_formatted" => Currency::getFormattedName(Currency::ID_RUB),
            "unit" => $this->resource->unit,
            "count" => $this->resource->pivot->count ?? null,
            "route" => $this->resource->web_route,
        ];
    }
}
