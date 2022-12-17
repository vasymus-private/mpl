<?php

namespace Domain\FAQs\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class FaqDTO extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $name;
}
