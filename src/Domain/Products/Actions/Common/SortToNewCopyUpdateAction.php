<?php

namespace Domain\Products\Actions\Common;

use Domain\Common\Actions\BaseAction;

class SortToNewCopyUpdateAction extends BaseAction
{
    /**
     * @var \Domain\Products\Actions\Common\CheckIsForCopyingAction
     */
    private CheckIsForCopyingAction $checkIsForCopyingAction;

    /**
     * @param \Domain\Products\Actions\Common\CheckIsForCopyingAction $checkIsForCopyingAction
     */
    public function __construct(CheckIsForCopyingAction $checkIsForCopyingAction)
    {
        $this->checkIsForCopyingAction = $checkIsForCopyingAction;
    }

    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[] $items
     *
     * @return \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[][] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[][] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[][]
     */
    public function execute(array $items): array
    {
        return collect($items)->reduce([$this, '_reduceCB'], [
            'new' => [],
            'copy' => [],
            'update' => [],
        ]);
    }

    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[][] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[][] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[][] $acc
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO $item
     *
     * @return \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[][] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[][] | \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[][]
     */
    public function _reduceCB(array $acc, $item): array
    {
        if ($this->checkIsForCopyingAction->execute($item)) {
            $acc['copy'][] = $item;

            return $acc;
        }

        if (! $item->id) {
            $acc['new'][] = $item;

            return $acc;
        }

        $acc['update'][] = $item;

        return $acc;
    }
}
