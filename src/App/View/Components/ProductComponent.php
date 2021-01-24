<?php

namespace App\View\Components;

use App\Models\Product\Product;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ProductComponent extends Component
{
    /**
     * @var Product
     * */
    public $product;

    /**
     * @var array
     * */
    public $asideIds;

    /**
     * Create a new component instance.
     *
     * @param Product $product
     * @param array $asideIds
     *
     * @return void
     */
    public function __construct(Product $product, array $asideIds = [])
    {
        $this->product = $product;
        $this->asideIds = $asideIds;
    }

    public function instructions(): Collection
    {
        return $this->product->getMedia(Product::MC_FILES);
    }

    public function mainImage(): string
    {
        return $this->product->getFirstMediaUrl(Product::MC_MAIN_IMAGE);
    }

    public function images(): Collection
    {
        return $this->product->getMedia(Product::MC_ADDITIONAL_IMAGES);
    }

    public function isWithVariations(): bool
    {
        return $this->product->variations->isNotEmpty();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.product-component');
    }
}
