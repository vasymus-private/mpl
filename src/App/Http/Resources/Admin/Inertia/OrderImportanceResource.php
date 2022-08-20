<?php

namespace App\Http\Resources\Admin\Inertia;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderImportanceResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Orders\Models\OrderImportance
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
            'color' => $this->resource->color,
        ];
    }
}
