<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditProduct;

use Spatie\DataTransferObject\DataTransferObject;

class CharCategoryDTO extends DataTransferObject
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
     * @var int|null
     */
    public ?int $ordering;

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[]
     */
    public array $chars = [];
}
