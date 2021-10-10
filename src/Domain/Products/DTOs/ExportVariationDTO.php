<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ExportVariationDTO extends DataTransferObject
{
    public string $uuid;

    public string $name;

    public static function fromModel(Product $variation): self
    {
        return new self([
            'uuid' => $variation->uuid,
            'name' => $variation->name,
            // todo
        ]);
    }
}
