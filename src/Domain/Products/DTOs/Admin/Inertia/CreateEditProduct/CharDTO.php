<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditProduct;

use Spatie\DataTransferObject\DataTransferObject;

class CharDTO extends DataTransferObject
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
     * @var string|null
     */
    public ?string $value;

    /**
     * @var int|null
     */
    public ?int $type_id;

    /**
     * @var int|null
     */
    public ?int $ordering;

    /**
     * @var int|null
     */
    public ?int $category_id;

    /**
     * @var string|null
     */
    public ?string $category_uuid;
}
