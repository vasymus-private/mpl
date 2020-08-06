<?php

namespace App\View\Components;

use App\Models\Product\Product;
use Illuminate\View\Component;

class ProductItemComponent extends Component
{
    /**
     * @var Product
     * */
    public $product;

    /**
     * @var int
     * */
    public $index;

    /**
     * @var int|null
     * */
    public $perPage;

    /**
     * @var int|null
     * */
    public $currentPage;

    /**
     * Create a new component instance.
     *
     * @param Product $product
     * @param int $index
     * @param int|null $perPage
     * @param int|null $currentPage
     *
     * @return void
     */
    public function __construct(Product $product, int $index, int $perPage = null, int $currentPage = null)
    {
        $this->product = $product;
        $this->index = $index;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.product-item-component');
    }

    public function orderNumber()
    {
        return ($this->perPage * ($this->currentPage - 1)) + $this->index + 1;
    }
}
