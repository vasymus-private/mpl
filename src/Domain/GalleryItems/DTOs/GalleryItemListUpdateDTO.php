<?php

namespace Domain\GalleryItems\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class GalleryItemListUpdateDTO extends DataTransferObject
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
     * @var bool|null
     */
    public ?bool $is_active;

    /**
     * @var int|null
     */
    public ?int $ordering;
}
