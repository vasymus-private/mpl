<?php

namespace App\Http\Livewire\Admin;

use Domain\Products\Models\Brand;

trait HasBrands
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
     */
    public array $brands;

    protected function initBrandsOptions()
    {
        $this->brands = Brand::getBrandOptions();
    }
}
