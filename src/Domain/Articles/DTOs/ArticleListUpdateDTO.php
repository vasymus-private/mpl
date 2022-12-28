<?php

namespace Domain\Articles\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class ArticleListUpdateDTO extends DataTransferObject
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
