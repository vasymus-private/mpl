<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Products\Models\Brand;
use Illuminate\Support\Facades\Cache;

trait HasBrands
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
     */
    public array $brands;

    protected function initBrandsOptions()
    {
        $this->brands = Cache::store('array')->rememberForever('options-brands', function () {
            return Brand::query()->select(["id", "name"])->get()->map(fn (Brand $brand) => OptionDTO::fromBrand($brand)->toArray())->all();
        });
    }
}
