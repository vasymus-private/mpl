<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;

/**
 * @mixin \App\Http\Livewire\Admin\ShowProduct\ShowProduct
 * @mixin \App\Http\Livewire\Admin\ShowProduct\BaseShowProduct
 */
trait HasOthersTab
{
    /**
     * @var string[]
     */
    public array $relatedCategories = [];

    protected function getOthersTabRules(): array
    {
        return [
            'item.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
        ];
    }

    /**
     * @return string[]
     */
    protected function getOthersTabMessages(): array
    {
        return [];
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

    protected function pushToRelatedCategory(string $id)
    {
        $relatedCategories = $this->relatedCategories;
        $relatedCategories[] = $id;
        $this->relatedCategories = array_unique($relatedCategories);
    }

    protected function initRelatedCategories(Product $product)
    {
        $this->relatedCategories = $product->relatedCategories->pluck('id')->map(fn($id) => (string)$id)->toArray();
    }
}
