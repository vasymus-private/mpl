<?php

namespace Domain\Common\DTOs;

use Domain\Products\Models\Brand;
use Spatie\DataTransferObject\DataTransferObject;

class OptionDTO extends DataTransferObject
{
    public int $value;

    public string $label;

    public static function fromBrand(Brand $brand): self
    {
        return new self([
            'value' => $brand->id,
            'label' => $brand->name,
        ]);
    }
}
