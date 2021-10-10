<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ExportProductDTO extends DataTransferObject
{
    public string $uuid;

    public string $name;

    public string $slug;

    public ?int $category_id;

    public ?int $ordering;

    /**
     * @var int|bool
     */
    public $is_active;

    /**
     * @var int|bool
     */
    public $is_with_variations;

    public ?int $brand_id;

    /**
     * @var float|int|null
     */
    public $coefficient;

    public ?string $coefficient_description;

    /**
     * @var int|bool
     */
    public $coefficient_description_show;

    public ?string $coefficient_variation_description;

    public ?string $price_name;

    public ?string $admin_comment;

    public ?float $price_purchase;

    public ?int $price_purchase_currency_id;

    public ?string $unit;

    public ?float $price_retail;

    public ?int $price_retail_currency_id;

    public int $availability_status_id;

    public ?string $preview;

    public ?string $description;

    public string $accessory_name;

    public string $similar_name;

    public string $related_name;

    public string $work_name;

    public string $instruments_name;

    public static function fromModel(Product $product): self
    {
        return new self([
            'uuid' => $product->uuid,
            'name' => $product->name,
            'slug' => $product->slug,

        ]);
    }
}
