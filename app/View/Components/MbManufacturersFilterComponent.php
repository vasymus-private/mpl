<?php

namespace App\View\Components;

use App\Models\Manufacturer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class MbManufacturersFilterComponent extends Component
{
    /**
     * @var Collection|Manufacturer[]
     * */
    public $manufacturers;

    /**
     * Create a new component instance.
     *
     * @param array $productIds
     *
     * @return void
     */
    public function __construct($productIds = [])
    {
        $this->manufacturers = Manufacturer
            ::query()
            ->withCount([
                "products" => function(Builder $builder) use($productIds) {
                    return $builder->whereIn(Product::TABLE . ".id", $productIds);
                },
            ])
            ->having("products_count", ">", 0)
            ->get()
        ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.mb-manufacturers-filter-component');
    }
}
