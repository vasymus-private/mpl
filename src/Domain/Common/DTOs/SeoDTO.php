<?php

namespace Domain\Common\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class SeoDTO extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $title;

    /**
     * @var string|null
     */
    public ?string $h1;

    /**
     * @var string|null
     */
    public ?string $keywords;

    /**
     * @var string|null
     */
    public ?string $description;
}
