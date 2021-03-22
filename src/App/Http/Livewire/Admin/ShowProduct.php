<?php

namespace App\Http\Livewire\Admin;

use Domain\Products\Models\Product\Product;
use Livewire\Component;

class ShowProduct extends Component
{
    public ?Product $product;

    protected array $rules = [
        'product.name' => 'required|string|max:199',
        'product.is_active' => 'nullable|boolean',
        'product.slug' => 'required|string|max:199',
    ];

    public function save()
    {
        $this->validate();

        $this->product->save();
    }

    public function render()
    {
        return view('admin.livewire.show-product');
    }
}
