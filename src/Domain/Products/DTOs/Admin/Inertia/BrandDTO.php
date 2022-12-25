<?php

namespace Domain\Products\DTOs\Admin\Inertia;

use Domain\Common\DTOs\MediaDTO;
use Domain\Common\DTOs\SeoDTO;
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
     * @var \Domain\Common\DTOs\MediaDTO|null
     */
    public ?MediaDTO $mainImage;

    /**
     * @var \Domain\Common\DTOs\SeoDTO|null
     */
    public ?SeoDTO $seo;
}
