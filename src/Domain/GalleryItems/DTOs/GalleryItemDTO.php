<?php

namespace Domain\GalleryItems\DTOs;

use Domain\Common\DTOs\SeoDTO;
use Spatie\DataTransferObject\DataTransferObject;

class GalleryItemDTO extends DataTransferObject
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
     * @var \Domain\Common\DTOs\SeoDTO|null
     */
    public ?SeoDTO $seo;
}
