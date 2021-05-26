<?php

namespace Domain\Common\DTOs;

use Domain\Common\Models\Currency;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
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

    public static function fromCurrency(Currency $currency): self
    {
        return new self([
            'value' => $currency->id,
            'label' => $currency->name,
        ]);
    }

    public static function fromAvailabilityStatus(AvailabilityStatus $availabilityStatus): self
    {
        return new self([
            'value' => $availabilityStatus->id,
            'label' => $availabilityStatus->name,
        ]);
    }

    public static function fromCategory(Category $category, int $level = 1): self
    {
        return new self([
            'value' => $category->id,
            'label' => implode('', array_fill(0, $level - 1, '.')) . $category->name,
        ]);
    }
}
