<?php

namespace App\Http\Resources\Admin;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'uuid' => $this->resource->uuid,
            'parent_id' => $this->resource->parent_id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'is_active' => $this->resource->is_active,
            'ordering' => $this->resource->ordering,
            'description' => $this->resource->description,
            'seo' => $this->resource->seo,
            // @phpstan-ignore-next-line
            'products' => $this->resource->products->map(fn (Product $product) => [
                'id' => $product->id,
                'uuid' => $product->uuid,
                'name' => $product->name,
                'is_active' => $product->is_active,
            ]),
        ];
    }
}
