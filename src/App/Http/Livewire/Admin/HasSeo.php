<?php

namespace App\Http\Livewire\Admin;

use Domain\Seo\Models\Seo;

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
            'seo.title' => 'nullable|max:199',
            'seo.h1' => 'nullable|max:199',
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