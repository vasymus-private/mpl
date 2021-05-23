<?php

namespace Domain\Products\DTOs;

use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class VariationAdminDTO extends DataTransferObject
{
    public ?int $id;

    public ?int $parent_id;

    public ?string $name;

    public ?int $ordering;

    public bool $is_active = false;

    public ?string $coefficient;

    public ?string $price_purchase;

    public ?int $price_purchase_currency_id;

    public ?string $unit;

    public ?string $price_retail;

    public ?int $price_retail_currency_id;

    public int $availability_status_id = AvailabilityStatus::ID_NOT_AVAILABLE;

    public ?string $preview;

    /**
     * @var array|null @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public ?array $main_image;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO[]}
     */
    public array $additional_images = [];

    public static function fromModel(Product $product): self
    {
        /** @var \Domain\Common\Models\CustomMedia|null $mainImage $mainImage */
        $mainImage = $product->getFirstMedia(Product::MC_MAIN_IMAGE);

        return new self([
            'id' => $product->id,
            'parent_id' => $product->parent_id,
            'name' => $product->name,
            'ordering' => $product->ordering ?: 500,
            'is_active' => (bool)$product->is_active,
            'coefficient' => $product->coefficient,
            'price_purchase' => $product->price_purchase,
            'price_purchase_currency_id' => $product->price_purchase_currency_id,
            'unit' => $product->unit,
            'price_retail' => $product->price_retail,
            'price_retail_currency_id' => $product->price_retail_currency_id,
            'availability_status_id' => $product->availability_status_id,
            'preview' => $product->preview,
            'main_image' => $mainImage ? FileDTO::fromCustomMedia($mainImage)->toArray() : null,
            'additional_images' => $product->getMedia(Product::MC_ADDITIONAL_IMAGES)->map(fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray())->all(),
        ]);
    }
}
