<?php

namespace App\Http\Livewire\Admin;

use Domain\Seo\Models\Seo;

/**
 * @property \Domain\Products\Models\Category|\Domain\Products\Models\Product\Product $item
 */
trait HasSeo
{
    /**
     * @var \Domain\Seo\Models\Seo
     */
    public Seo $seo;

    /**
     * @return string[]
     */
    protected function getSeoRules(): array
    {
        return [
            'seo.title' => 'nullable|max:250',
            'seo.h1' => 'nullable|max:250',
            'seo.keywords' => 'nullable|max:65000',
            'seo.description' => 'nullable|max:65000',
        ];
    }

    protected function initSeo()
    {
        $this->seo = $this->item->seo ?: new Seo();
    }

    protected function saveSeo()
    {
        $this->item->seo()->save($this->seo);
    }
}
