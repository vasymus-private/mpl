<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Products\Models\Product\Product;

class Description extends BaseShowProduct
{
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

    protected function getComponentName(): string
    {
        return ShowProductConstants::COMPONENT_NAME_DESCRIPTION;
    }


    public function mount()
    {
//        dump($this->item->uuid);
        $this->initCommonShowProduct();

        $this->initItem();
    }

    public function render()
    {
        return view('admin.livewire.show-product.description');
    }

    public function handleSave()
    {
        $this->validateBeforeHandleSave();
        $this->getRefreshedItemOrNew();

        $this->saveProduct();
    }

    protected function saveProduct()
    {
        $saveAttributes = [
            'preview' => $this->item->preview,
            'description' => $this->item->description,
        ];
        /** @var \Domain\Products\Models\Product\Product $item */
        $item = Product::query()->firstOrNew(['uuid' => $this->item->uuid]);
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
}
