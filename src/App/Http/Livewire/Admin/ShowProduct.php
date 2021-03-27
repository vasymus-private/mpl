<?php

namespace App\Http\Livewire\Admin;

use Domain\Products\Models\Brand;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Support\H;

class ShowProduct extends Component
{
    public Product $product;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\InformationalPrice[]
     */
    public Collection $infoPrices;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Brand[]
     */
    public Collection $brands;

    protected array $rules = [
        'product.name' => 'required|string|max:199',
        'product.is_active' => 'nullable|boolean',
        'product.slug' => 'required|string|max:199',
        'product.ordering' => 'integer|nullable',
        'product.brand_id' => 'integer|nullable|exists:' . Brand::class . ",id",
        'product.coefficient' => 'nullable|numeric',
        'product.coefficient_description' => 'nullable|string|max:199',
        'product.coefficient_description_show' => 'nullable|boolean',
        'product.price_name' => 'nullable|string|max:199',

        'infoPrices.*.price' => 'required|numeric',
        'infoPrices.*.name' => 'required|string|max:199',
    ];

    public function mount()
    {
        $this->brands = Brand::query()->select(["id", "name"])->get();
        $this->infoPrices = $this->product->infoPrices;
    }

    public function save()
    {
        $this->validate();

        $this->product->save();

        foreach ($this->infoPrices as $infoPrice) {
            $infoPrice->product_id = $this->product->id;
            $infoPrice->save();
        }
    }

    public function deleteInfoPrice($id)
    {
        /** @var \Domain\Products\Models\InformationalPrice $infoPrice */
        $infoPrice = $this->infoPrices->first(fn(InformationalPrice $ip) => (string)$ip->id === (string)$id);
        if ($infoPrice) {
            $infoPrice->delete();
            $this->infoPrices = $this->infoPrices->filter(fn(InformationalPrice $ip) => (string)$ip->id !== (string)$id);
        }
    }

    public function addInfoPrice()
    {
        $this->infoPrices->add(new InformationalPrice());
    }

    /**
     * @param mixed $name
     * @param mixed $value
     *
     * @see {@link https://github.com/livewire/livewire/issues/823#issuecomment-751321838}
     */
    public function updated($name, $value)
    {
        data_set($this, $name, H::trimAndNullEmptyString($value));
    }

    public function render()
    {
        return view('admin.livewire.show-product');
    }
}
