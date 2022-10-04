<?php

namespace Domain\Products\DTOs\Admin\Inertia;

use Spatie\DataTransferObject\DataTransferObject;

class CategoriesListUpdateDTO extends DataTransferObject
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
}
