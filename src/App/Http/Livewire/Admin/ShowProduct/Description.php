<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Products\Models\Product\Product;
use Livewire\Component;

class Description extends Component
{
    use HasCommonShowProduct;

    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $item;

    /**
     * @var string[]
     */
    protected $listeners = [
        ShowProductConstants::EVENT_SAVE_DESCRIPTIONS => 'saveDescription',
    ];

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'item.preview' => 'nullable|max:65000',
            'item.description' => 'nullable|max:65000',
        ];
    }

    /**
     * @return array
     */
    protected function queryString(): array
    {
        return array_merge($this->getHasShowProductQueryString(), []);
    }

    public function mount()
    {
        $this->initCommonShowProduct();

        $this->initItem();
    }

    public function render()
    {
        return view('admin.livewire.show-product.description');
    }

    public function saveDescription()
    {
        $this->validate();

        $this->saveProduct();
    }

    protected function saveProduct()
    {
        $saveAttributes = [
            'preview' => $this->item->preview,
            'description' => $this->item->description,
        ];
        /** @var \Domain\Products\Models\Product\Product $item */
        $item = $this->isCreating
            ? new Product()
            : Product::query()->findOrFail($this->item->id);
        $item->forceFill($saveAttributes);
        $item->save();

        $this->item = $item;
    }

    protected function initItem()
    {
        if ($this->isCreatingFromCopy) {
            $copyProduct = $this->getCopyProduct();
            if ($copyProduct !== null) {
                $this->initAsCopiedItem($copyProduct);
                return;
            }
        }
    }

    protected function initAsCopiedItem(Product $origin)
    {
        // fill item with attributes
        $attributes = collect($origin->toArray())
            ->only($this->getCopyItemAttributes())
            ->toArray();
        $item = new Product();
        $item->forceFill($attributes);
        $this->item = $item;
    }
}
