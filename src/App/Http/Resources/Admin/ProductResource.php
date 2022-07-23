<?php

namespace App\Http\Resources\Admin;

use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
        /** @var \Domain\Common\Models\CustomMedia $mainImage */
        $mainImage = $this->resource->getFirstMedia(Product::MC_MAIN_IMAGE);

        return [
            'id' => $this->resource->id,
            'uuid' => $this->resource->uuid,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'ordering' => $this->resource->ordering,
            'is_active' => $this->resource->is_active,
            'unit' => $this->resource->unit,
            'price_purchase' => $this->resource->price_purchase,
            'price_purchase_currency_id' => $this->resource->price_purchase_currency_id,
            'price_purchase_formatted' => $this->resource->price_purchase_formatted,
            'price_retail' => $this->resource->price_retail,
            'price_retail_currency_id' => $this->resource->price_retail_currency_id,
            'price_retail_formatted' => $this->resource->price_retail_formatted,
            'admin_comment' => $this->resource->admin_comment,
            'availability_status_id' => $this->resource->availability_status_id,
            'availability_status_name' => $this->resource->availability_status_name,
            'availability_status_name_short' => $this->resource->availability_status_name_short,
            'parent_id' => $this->resource->parent_id,
            'brand_id' => $this->resource->brand_id,
            'category_id' => $this->resource->category_id,
            'web_route' => $this->resource->web_route,
            'is_with_variations' => $this->resource->is_with_variations,
            'coefficient' => $this->resource->coefficient,
            'coefficient_description' => $this->resource->coefficient_description,
            'coefficient_description_show' => $this->resource->coefficient_description_show,
            'coefficient_variation_description' => $this->resource->coefficient_variation_description,
            'price_name' => $this->resource->price_name,
            'preview' => $this->resource->preview,
            'description' => $this->resource->description,
            'accessory_name' => $this->resource->accessory_name,
            'similar_name' => $this->resource->similar_name,
            'related_name' => $this->resource->related_name,
            'work_name' => $this->resource->work_name,
            'instruments_name' => $this->resource->instruments_name,
            'seo' => $this->resource->seo,
            'infoPrices' => $this->resource->infoPrices,
            'instructions' => $this->resource
                ->getMedia(Product::MC_FILES)
                ->map(function (CustomMedia $media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->getFullUrl(),
                        'name' => $media->name,
                        'file_name' => $media->file_name,
                        'order_column' => $media->order_column,
                    ];
                })
                ->sortByDesc('order_column')
                ->values(),
            'mainImage' => $mainImage
                ? [
                    'id' => $mainImage->id,
                    'url' => $mainImage->getFullUrl(),
                    'name' => $mainImage->name,
                    'file_name' => $mainImage->file_name,
                ]
                : null,
            'additionalImages' => $this->resource
                ->getMedia(Product::MC_ADDITIONAL_IMAGES)
                ->map(function (CustomMedia $media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->getFullUrl(),
                        'name' => $media->name,
                        'file_name' => $media->file_name,
                        'order_column' => $media->order_column,
                    ];
                }),
        ];
    }
}
