<?php

namespace App\Http\Livewire\Admin\ShowProduct;

/**
 * @mixin \App\Http\Livewire\Admin\ShowProduct\ShowProduct
 * @mixin \App\Http\Livewire\Admin\ShowProduct\BaseShowProduct
 */
trait HasDescription
{
    /**
     * @return array
     */
    protected function getDescriptionTabRules(): array
    {
        return [
            'item.preview' => 'nullable|max:65000',
            'item.description' => 'nullable|max:65000',
        ];
    }

    /**
     * @return string[]
     */
    protected function getDescriptionTabMessages(): array
    {
        return [

        ];
    }

    protected function initDescriptionTab()
    {
    }

    protected function handleSaveDescriptionTab()
    {
    }

    protected function getDescriptionTabAttributes(): array
    {
        return [
            'preview' => $this->item->preview,
            'description' => $this->item->description,
        ];
    }
}
