<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditProduct;

use Spatie\DataTransferObject\DataTransferObject;

class InfoPriceDTO extends DataTransferObject
{
    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var bool|null
     */
    public ?bool $is_copy;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var float|int|null
     */
    public $price;
}
