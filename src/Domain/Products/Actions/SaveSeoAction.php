<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\SeoDTO;
use Domain\Seo\Models\Seo;

class SaveSeoAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Products\Models\Category $target
     * @param \Domain\Products\DTOs\Admin\Inertia\SeoDTO|null $seoDTO
     *
     * @return void
     */
    public function execute($target, SeoDTO $seoDTO = null)
    {
        if (! $target->id) {
            $target->save();
        }

        $seo = $target->seo ?? new Seo();
        if (! $seoDTO) {
            $seo->delete();

            return;
        }

        $seo->title = $seoDTO->title;
        $seo->h1 = $seoDTO->h1;
        $seo->keywords = $seoDTO->keywords;
        $seo->description = $seoDTO->description;
        $target->seo()->save($seo);
    }
}
