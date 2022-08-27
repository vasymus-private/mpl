<?php

namespace Domain\Products\Actions\Common;

use Domain\Common\Actions\BaseAction;

class CheckIsForCopyingAction extends BaseAction
{
    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO|\Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO|\Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO $item
     *
     * @return bool
     */
    public function execute($item): bool
    {
        return $item->is_copy && $item->id;
    }
}
