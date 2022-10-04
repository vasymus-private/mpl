<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\SimpleCategoryDTO;

class GetCategoryAndSubtreeIdsAction extends BaseAction
{
    private GetCategoryAndSubtreeAction $getCategoryAndSubtreeAction;

    public function __construct(GetCategoryAndSubtreeAction $getCategoryAndSubtreeAction)
    {
        $this->getCategoryAndSubtreeAction = $getCategoryAndSubtreeAction;
    }

    /**
     * @param int|int[] $idOrIds
     *
     * @return int[]
     */
    public function execute($idOrIds): array
    {
        $ids = [];

        if (is_integer($idOrIds)) {
            $idOrIds = [$idOrIds];
        }

        foreach ($idOrIds as $id) {
            $categoryAndSubtree = $this->getCategoryAndSubtreeAction->execute($id);
            if (! $categoryAndSubtree) {
                continue;
            }

            $res = $this->cb($ids, $categoryAndSubtree);
            $ids = array_merge($ids, $res);
        }

        return array_unique($ids);
    }

    /**
     * @param int[] $acc
     * @param \Domain\Products\DTOs\SimpleCategoryDTO $categoryDTO
     *
     * @return int[]
     */
    protected function cb(array $acc, SimpleCategoryDTO $categoryDTO): array
    {
        $acc[] = $categoryDTO->id;
        foreach ($categoryDTO->subcategories as $subcategory) {
            $acc = $this->cb($acc, $subcategory);
        }

        return $acc;
    }
}
