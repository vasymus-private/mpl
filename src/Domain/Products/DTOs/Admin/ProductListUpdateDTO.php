<?php

namespace Domain\Products\DTOs\Admin;

use Spatie\DataTransferObject\DataTransferObject;

class ProductListUpdateDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

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
     * @var float|null
     */
    public ?float $price_purchase;

    /**
     * @var int|null
     */
    public ?int $price_purchase_currency_id;

    /**
     * @var float|null
     */
    public ?float $price_retail;

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
}
