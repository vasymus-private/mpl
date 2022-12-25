<?php

namespace Domain\Common\Actions;

use Domain\Common\DTOs\SeoDTO;
use Domain\Seo\Models\Seo;

class SaveSeoAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Products\Models\Category|\Domain\FAQs\Models\FAQ $target
     * @param \Domain\Common\DTOs\SeoDTO|null $seoDTO
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
