<?php

namespace App\Services\TransferFromOrigin\DTOs;

class ManufacturerDTO extends AbstractDTO
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string|null */
    public $preview;

    /** @var string|null */
    public $description;

    /** @var string|null */
    public $image;
}
