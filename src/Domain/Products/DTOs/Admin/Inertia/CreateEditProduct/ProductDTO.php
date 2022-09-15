<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditProduct;

use Domain\Products\DTOs\Admin\Inertia\MediaDTO;
use Domain\Products\DTOs\Admin\Inertia\SeoDTO;
use Spatie\DataTransferObject\DataTransferObject;

class ProductDTO extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $slug;

    /**
     * @var int|null
     */
    public ?int $ordering;

    /**
     * @var bool|null
     */
    public ?bool $is_active;

    /**
     * @var string|null
     */
    public ?string $unit;

    /**
     * @var float|int|null
     */
    public $price_purchase;

    /**
     * @var int|null
     */
    public ?int $price_purchase_currency_id;

    /**
     * @var float|int|null
     */
    public $price_retail;

    /**
     * @var int|null
     */
    public ?int $price_retail_currency_id;

    /**
     * @var string|null
     */
    public ?string $admin_comment;

    /**
     * @var int|null
     */
    public ?int $availability_status_id;

    /**
     * @var int|null
     */
    public ?int $brand_id;

    /**
     * @var int|null
     */
    public ?int $category_id;

    /**
     * @var bool|null
     */
    public ?bool $is_with_variations;

    /**
     * @var float|int|null
     */
    public $coefficient;

    /**
     * @var string|null
     */
    public ?string $coefficient_description;

    /**
     * @var bool|null
     */
    public ?bool $coefficient_description_show;

    /**
     * @var string|null
     */
    public ?string $coefficient_variation_description;

    /**
     * @var string|null
     */
    public ?string $price_name;

    /**
     * @var string|null
     */
    public ?string $preview;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var string|null
     */
    public ?string $accessory_name;

    /**
     * @var string|null
     */
    public ?string $similar_name;

    /**
     * @var string|null
     */
    public ?string $related_name;

    /**
     * @var string|null
     */
    public ?string $work_name;

    /**
     * @var string|null
     */
    public ?string $instruments_name;

    /**
     * @var int[]
     */
    public array $relatedCategoriesIds = [];

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\SeoDTO|null
     */
    public ?SeoDTO $seo;

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO[]
     */
    public array $infoPrices = [];

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\MediaDTO[]
     */
    public array $instructions = [];

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\MediaDTO|null
     */
    public ?MediaDTO $mainImage;

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\MediaDTO[]
     */
    public array $additionalImages = [];

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[]
     */
    public array $charCategories = [];

    /**
     * @var int[]
     */
    public array $accessories = [];

    /**
     * @var int[]
     */
    public array $similar = [];

    /**
     * @var int[]
     */
    public array $related = [];

    /**
     * @var int[]
     */
    public array $works = [];

    /**
     * @var int[]
     */
    public array $instruments = [];

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO[]
     */
    public array $variations = [];
}
