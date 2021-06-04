<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;

class DeleteCategoryAction
{
    public function execute(Category $category)
    {
        $category->subcategories->each(function(Category $subcategory) {
            /** @var self $deleteCategoryAction */
            $deleteCategoryAction = resolve(static::class);
            $deleteCategoryAction->execute($subcategory);
        });
        $category->products->each(function(Product $product) {
            $product->is_active = false;
            $product->save();
        });
        $category->delete();
    }
}
