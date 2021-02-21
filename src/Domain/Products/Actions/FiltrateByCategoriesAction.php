<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\FiltrateByCategoriesParamsDTO;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;

class FiltrateByCategoriesAction
{
    public function execute(Builder $query, FiltrateByCategoriesParamsDTO $params): Builder
    {
        foreach ([$params->subcategory3, $params->subcategory2, $params->subcategory1, $params->category] as $cat) {
            /** @var \Domain\Products\Models\Category $cat*/
            if ($cat) {
                $query->where(Product::TABLE . ".category_id", $cat->id);
                break;
            }
        }

        return $query;
    }
}
