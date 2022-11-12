<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditProduct;

use Domain\Common\DTOs\MediaDTO;
use Spatie\DataTransferObject\DataTransferObject;

class VariationDTO extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var string|null
     */
    public ?string $uuid;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var bool|null
     */
    public ?bool $is_active;

    /**
     * @var int|null
     */
    public ?int $ordering;

    /**
     * @var float|int|null
     */
    public $coefficient;

    /**
     * @var string|null
     */
    public ?string $coefficient_description;

    /**
     * @var string|null
     */
    public ?string $unit;

    /**
     * @var int|null
     */
    public ?int $availability_status_id;

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
    public ?string $preview;

    /**
     * @var \Domain\Common\DTOs\MediaDTO|null
     */
    public ?MediaDTO $mainImage;

    /**
     * @var \Domain\Common\DTOs\MediaDTO[]
     */
    public array $additionalImages = [];
}
