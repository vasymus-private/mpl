<?php

namespace App\Http\Resources\Web\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Seo\Models\Seo
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
            'title' => $this->resource->title,
            'keywords' => $this->resource->keywords,
            'description' => $this->resource->description,
        ];
    }
}
