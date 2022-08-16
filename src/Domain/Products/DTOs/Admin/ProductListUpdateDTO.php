<?php

namespace Domain\Products\DTOs\Admin;

use Spatie\DataTransferObject\DataTransferObject;

class ProductListUpdateDTO extends DataTransferObject
{
    public int $id;

    public string $name;
}
