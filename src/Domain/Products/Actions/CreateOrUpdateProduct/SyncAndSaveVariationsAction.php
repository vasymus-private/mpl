<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Product\Product;

class SyncAndSaveVariationsAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO[] $variations
     *
     * @return void
     */
    public function execute(Product $target, array $variations)
    {
    }
}
