<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Product\Product;

class SaveCharCategoriesAndCharsAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[] $charCategories
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[] $chars
     *
     * @return void
     */
    public function execute(Product $target, array $charCategories, array $chars)
    {

    }
}
