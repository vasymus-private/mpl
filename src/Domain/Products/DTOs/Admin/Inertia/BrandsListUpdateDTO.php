<?php

namespace Domain\Products\DTOs\Admin\Inertia;

use Spatie\DataTransferObject\DataTransferObject;

class BrandsListUpdateDTO extends DataTransferObject
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
     * @var string|null
     */
    public ?string $preview;
}
