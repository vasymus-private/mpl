<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\FiltrateByCategoriesParamsDTO;
use Domain\Products\QueryBuilders\ProductQueryBuilder;

class FiltrateByCategoriesAction
{
    public function execute(ProductQueryBuilder $query, FiltrateByCategoriesParamsDTO $params): ProductQueryBuilder
    {
        return $query->forMainCategory([$params->subcategory3, $params->subcategory2, $params->subcategory1, $params->category]);
    }
}
