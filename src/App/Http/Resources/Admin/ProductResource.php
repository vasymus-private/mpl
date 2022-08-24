<?php

namespace App\Http\Resources\Admin;

use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
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
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $relatedMapCB = fn (Product $product) => [
            'id' => $product->id,
            'uuid' => $product->uuid,
            'name' => $product->name,
            'image' => $product->main_image_md_thumb_url,
            'price_rub_formatted' => $product->price_retail_rub_formatted,
        ];

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
            'relatedCategoriesIds' => $this->resource->relatedCategories->pluck('id'),
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
                        'uuid' => $media->uuid,
                        'url' => $media->getFullUrl(),
                        'name' => $media->name,
                        'file_name' => $media->file_name,
                        'order_column' => $media->order_column,
                    ];
                })
                ->sortByDesc('order_column')
                ->values(),
            'mainImage' => $this->resource->main_image_media
                ? [
                    'id' => $this->resource->main_image_media->id,
                    'uuid' => $this->resource->main_image_media->uuid,
                    'url' => $this->resource->main_image_media->getFullUrl(),
                    'name' => $this->resource->main_image_media->name,
                    'file_name' => $this->resource->main_image_media->file_name,
                ]
                : null,
            'additionalImages' => $this->resource
                ->getMedia(Product::MC_ADDITIONAL_IMAGES)
                ->map(function (CustomMedia $media) {
                    return [
                        'id' => $media->id,
                        'uuid' => $media->uuid,
                        'url' => $media->getFullUrl(),
                        'name' => $media->name,
                        'file_name' => $media->file_name,
                        'order_column' => $media->order_column,
                    ];
                }),
            'charCategories' => $this->resource
                ->charCategories
                ->map(
                    fn (CharCategory $charCategory) => [
                        'id' => $charCategory->id,
                        'name' => $charCategory->name,
                        'product_id' => $charCategory->product_id,
                        'ordering' => $charCategory->ordering,
                        'chars' => $charCategory->chars->map(
                            fn (Char $char) => [
                                'id' => $char->id,
                                'name' => $char->name,
                                'value' => $char->value,
                                'product_id' => $char->product_id,
                                'type_id' => $char->type_id,
                                'category_id' => $char->category_id,
                                'ordering' => $char->ordering,
                            ]
                        ),
                    ]
                ),
            'accessories' => $this->resource
                ->accessory
                ->map($relatedMapCB),
            'similar' => $this->resource
                ->similar
                ->map($relatedMapCB),
            'related' => $this->resource
                ->related
                ->map($relatedMapCB),
            'works' => $this->resource
                ->works
                ->map($relatedMapCB),
            'instruments' => $this->resource
                ->instruments
                ->map($relatedMapCB),
            'variations' => $this->resource->variations->map(fn (Product $variation) => [
                'id' => $variation->id,
                'uuid' => $variation->uuid,
                'is_active' => $variation->is_active,
                'name' => $variation->name,
                'availability_status_id' => $variation->availability_status_id,
                'ordering' => $variation->ordering,
                'coefficient' => $variation->coefficient,
                'coefficient_description' => $variation->coefficient_description,
                'unit' => $variation->unit,
                'price_purchase' => $variation->price_purchase,
                'price_purchase_currency_id' => $variation->price_purchase_currency_id,
                'price_retail' => $variation->price_retail,
                'price_retail_currency_id' => $variation->price_retail_currency_id,
                'preview' => $variation->preview,
                'mainImage' => $variation->main_image_media
                    ? [
                        'id' => $variation->main_image_media->id,
                        'uuid' => $variation->main_image_media->uuid,
                        'url' => $variation->main_image_media->getFullUrl(),
                        'name' => $variation->main_image_media->name,
                        'file_name' => $variation->main_image_media->file_name,
                    ]
                    : null,
                'additionalImages' => $variation
                    ->getMedia(Product::MC_ADDITIONAL_IMAGES)
                    ->map(function (CustomMedia $media) {
                        return [
                            'id' => $media->id,
                            'uuid' => $media->uuid,
                            'url' => $media->getFullUrl(),
                            'name' => $media->name,
                            'file_name' => $media->file_name,
                            'order_column' => $media->order_column,
                        ];
                    }),
            ]),
        ];
    }
}
