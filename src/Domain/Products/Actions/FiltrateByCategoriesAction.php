<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\FiltrateByCategoriesParamsDTO;
use Domain\Products\QueryBuilders\ProductQueryBuilder;

class FiltrateByCategoriesAction
{
    /**
     * @param \Domain\Products\QueryBuilders\ProductQueryBuilder $query
     * @param \Domain\Products\DTOs\FiltrateByCategoriesParamsDTO $params
     *
     * @return \Domain\Products\QueryBuilders\ProductQueryBuilder
     */
    public function execute(ProductQueryBuilder $query, FiltrateByCategoriesParamsDTO $params): ProductQueryBuilder
    {
        $categoryIds = $this->getCategoryIds($params);

        if (empty($categoryIds)) {
            return $query;
        }

        return $query->forMainAndRelatedCategories($categoryIds);
    }

    /**
     * @param \Domain\Products\DTOs\FiltrateByCategoriesParamsDTO $params
     *
     * @return int[]
     */
    private function getCategoryIds(FiltrateByCategoriesParamsDTO $params): array
    {
        /** @var \Domain\Products\Models\Category[]|null[] $categories */
        $categories = [$params->subcategory3, $params->subcategory2, $params->subcategory1, $params->category];
        foreach ($categories as $category) {
            if (!$category) {
                continue;
            }

            return [$category->id];
        }

        return [];
    }
}
