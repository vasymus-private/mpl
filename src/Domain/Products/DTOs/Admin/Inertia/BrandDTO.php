<?php

namespace Domain\Products\DTOs\Admin\Inertia;

use Spatie\DataTransferObject\DataTransferObject;

class BrandDTO extends DataTransferObject
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
     * @var string|null
     */
    public ?string $preview;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\MediaDTO|null
     */
    public ?MediaDTO $mainImage;

    /**
     * @var \Domain\Products\DTOs\Admin\Inertia\SeoDTO|null
     */
    public ?SeoDTO $seo;
}
