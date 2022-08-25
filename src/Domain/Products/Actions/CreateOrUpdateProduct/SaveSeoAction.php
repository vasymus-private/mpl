<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\SeoDTO;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;

class SaveSeoAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\SeoDTO $seoDTO
     *
     * @return void
     */
    public function execute(Product $target, SeoDTO $seoDTO)
    {
        if (! $target->id) {
            $target->save();
        }

        $seo = $target->seo ?? new Seo();
        $seo->title = $seoDTO->title;
        $seo->h1 = $seoDTO->h1;
        $seo->keywords = $seoDTO->keywords;
        $seo->description = $seoDTO->description;
        $target->seo()->save($seo);
    }
}
