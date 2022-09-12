<?php

namespace Domain\Products\Actions\CreateOrUpdateCategory;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\SeoDTO;
use Domain\Products\Models\Category;
use Domain\Seo\Models\Seo;

class SaveSeoAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Category $target
     * @param \Domain\Products\DTOs\Admin\Inertia\SeoDTO|null $seoDTO
     *
     * @return void
     */
    public function execute(Category $target, SeoDTO $seoDTO = null)
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
