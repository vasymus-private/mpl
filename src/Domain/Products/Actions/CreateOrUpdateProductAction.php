<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO;
use Domain\Products\Models\Product\Product;

class CreateOrUpdateProductAction extends BaseAction
{
    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     * @param \Domain\Products\Models\Product\Product|null $target
     *
     * @return \Domain\Products\Models\Product\Product
     */
    public function execute(ProductDTO $productDTO, Product $target = null): Product
    {
    }
}
