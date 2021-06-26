<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Http\Livewire\Admin\HasSeo;
use Domain\Seo\Models\Seo;

/**
 * @mixin \App\Http\Livewire\Admin\ShowProduct\ShowProduct
 * @mixin \App\Http\Livewire\Admin\ShowProduct\BaseShowProduct
 */
trait HasSeoTab
{
    use HasSeo;

    /**
     * @return array
     */
    protected function getSeoTabRules(): array
    {
        return array_merge([], $this->getSeoRules());
    }

    /**
     * @return string[]
     */
    protected function getSeoTabMessages(): array
    {
        return [

        ];
    }

    protected function initSeoTab()
    {
        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            if ($originProduct !== null) {
                $seo = $originProduct->seo ?: new Seo();
                $seo->seoable_id = null;
                $seo->seoable_type = null;
                $this->seo = $seo;
                return;
            }
        }
        $this->initSeo();
    }

    protected function getSeoTabAttributes(): array
    {
        return [];
    }

    protected function handleSaveSeoTab()
    {
        $this->saveSeo();
    }
}
