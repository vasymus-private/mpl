<?php

namespace Domain\Users\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class BlacklistItemUpdateDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string|null
     */
    public ?string $email;

    /**
     * @var string|null
     */
    public ?string $ip;
}
