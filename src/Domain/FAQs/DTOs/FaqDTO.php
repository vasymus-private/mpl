<?php

namespace Domain\FAQs\DTOs;

use Domain\Common\DTOs\SeoDTO;
use Spatie\DataTransferObject\DataTransferObject;

class FaqDTO extends DataTransferObject
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
    public ?string $question;

    /**
     * @var string|null
     */
    public ?string $answer;

    /**
     * @var \Domain\Common\DTOs\SeoDTO|null
     */
    public ?SeoDTO $seo;
}
