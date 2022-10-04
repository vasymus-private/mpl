<?php

namespace App\Http\Resources\Admin\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;

class CharTypeResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Products\Models\CharType
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
