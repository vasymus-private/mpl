<?php

namespace App\Http\Resources\Web\Api;

use Domain\Products\Models\Category;
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
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'subcategories' => $this->resource->subcategories->map(fn (Category $subcategory1) => [
                'id' => $subcategory1->id,
                'name' => $subcategory1->name,
                'slug' => $subcategory1->slug,
                'subcategories' => $subcategory1->subcategories->map(fn (Category $subcategory2) => [
                    'id' => $subcategory2->id,
                    'name' => $subcategory2->name,
                    'slug' => $subcategory2->slug,
                ]),
            ]),
        ];
    }
}
