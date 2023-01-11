<?php

namespace Domain\Users\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class BlacklistDTO extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $email;

    /**
     * @var string|null
     */
    public ?string $ip;
}
