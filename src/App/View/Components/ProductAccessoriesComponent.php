<?php

namespace App\View\Components;

use Domain\Products\Models\Product\Product;
use Illuminate\View\Component;

class ProductAccessoriesComponent extends Component
{
    /**
     * @var Product
     * */
    public $product;

    /**
     * Create a new component instance.
     *
     * @param Product $product
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.product-accessories-component');
    }
}
