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
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|int|float|null
     */
    public $value;

    /**
     * @var int|null
     */
    public ?int $type_id;

    /**
     * @var int|null
     */
    public ?int $ordering;
}
