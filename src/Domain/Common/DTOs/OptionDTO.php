<?php

namespace Domain\Common\DTOs;

use Domain\Common\Models\Currency;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Illuminate\Support\HtmlString;
use Spatie\DataTransferObject\DataTransferObject;

class OptionDTO extends DataTransferObject
{
    /**
     * @var string|int|float|bool|null
     */
    public $value;

    /**
     * @var string|\Illuminate\Support\HtmlString
     */
    public $label;

    public bool $disabled = false;

    public bool $isHtmlString = false;

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

    public static function fromCategory(Category $category, int $level = 1, bool $disabled = false): self
    {
        $dot = '<span>.</span>';
        $label = implode('', array_fill(0, $level - 1, $dot)) . $category->name;
        return new self([
            'value' => $category->id,
            'label' => $label,
            'disabled' => $disabled,
            'isHtmlString' => true,
        ]);
    }

    /**
     * @param string[]|int[]|float[]|bool[]|null[] $itemsArr
     *
     * @return self[]
     */
    public static function fromItemsArr(array $itemsArr): array
    {
        $result = [];

        foreach ($itemsArr as $item) {
            $result[] = new self([
                'value' => $item,
                'label' => (string)$item,
            ]);
        }

        return $result;
    }
}
