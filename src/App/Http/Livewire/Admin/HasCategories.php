<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Products\Models\Category;

trait HasCategories
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category}
     * */
    public array $categories;

    public array $categoriesSelectOptions;

    /**
     * @param int[]|string[] $exclude
     *
     * @return void
     */
    protected function initCategoriesOptions(array $exclude = [])
    {
        $this->categories = Category::getTreeRuntimeCached()->reduce(function (array $acc, Category $category) use($exclude) {
            return $this->categoryToOption($acc, $category, 1, $exclude);
        }, []);

        $this->categoriesSelectOptions = Category::getTreeRuntimeCached()->reduce(function(array $acc, Category $category) use($exclude) {
            return $this->categoryToOption($acc, $category, 1, $exclude, false);
        }, []);
    }

    /**
     * @param array $acc
     * @param \Domain\Products\Models\Category $category
     * @param int $level
     * @param int[]|string[] $exclude
     * @param bool $isHtmlString
     *
     * @return array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category}
     */
    protected function categoryToOption(array $acc, Category $category, int $level = 1, array $exclude = [], bool $isHtmlString = true): array
    {
        $acc[] = OptionDTO::fromCategory(
            $category,
            $level,
            in_array($category->id, $exclude),
            $isHtmlString
        )->toArray();
        if ($category->relationLoaded('subcategories')) {
            foreach ($category->subcategories as $subcategory) {
                $acc = $this->categoryToOption($acc, $subcategory, $level + 1, $exclude, $isHtmlString);
            }
        }
        return $acc;
    }
}
