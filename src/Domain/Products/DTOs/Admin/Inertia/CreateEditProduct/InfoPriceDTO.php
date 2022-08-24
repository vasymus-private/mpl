<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditProduct;

class InfoPriceDTO
{
    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var float|int|null
     */
    public $price;
}
