<?php

namespace Domain\Products\DTOs\Admin\Inertia\CreateEditCategory;

use Domain\Products\DTOs\Admin\Inertia\SeoDTO;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryDTO extends DataTransferObject
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
     * @var int|null
     */
    public ?int $parent_id;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\SeoDTO|null
     */
    public ?SeoDTO $seo;
}
