<?php

namespace App\Http\Resources\Web\Api;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ParquetWorkCategoriesResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Products\Models\Category
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
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'products' => $this->resource->products->map(fn (Product $product) => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
            ]),
        ];
    }
}
