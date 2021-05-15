<?php

namespace Domain\Common\DTOs;

use Domain\Common\Models\Currency;
use Domain\Products\Models\AvailabilityStatus;
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
}
