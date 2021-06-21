<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Http\Livewire\Admin\HasSeo;
use Domain\Seo\Models\Seo;

trait HasSeoTab
{
    use HasSeo;

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
}
