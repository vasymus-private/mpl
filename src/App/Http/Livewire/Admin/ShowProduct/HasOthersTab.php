<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;

trait HasOthersTab
{
    /**
     * @var int[]
     */
    public array $relatedCategories;

    protected function getOthersTabRules(): array
    {
        return [
            [
                'item.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
            ]
        ];
    }

    protected function initOthersTab()
    {
        $product = $this->item;

        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            $product = $originProduct ?: $product;
        }

        $this->initRelatedCategories($product);
    }

    protected function getOthersTabAttributes(): array
    {
        return [
            'category_id' => $this->item->category_id,
        ];
    }

    protected function handleSaveOthersTab()
    {
        $this->item->relatedCategories()->sync($this->relatedCategories);
    }

    protected function initRelatedCategories(Product $product)
    {
        $this->relatedCategories = $product->relatedCategories->pluck('id')->toArray();
    }
}
