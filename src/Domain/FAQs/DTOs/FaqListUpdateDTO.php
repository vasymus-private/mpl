<?php

namespace Domain\FAQs\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class FaqListUpdateDTO extends DataTransferObject
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
}
