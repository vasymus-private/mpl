<?php

namespace Domain\Products\Actions\CreateOrUpdateCategory;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Actions\SaveSeoAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditCategory\CategoryDTO;
use Domain\Products\Models\Category;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateCategoryAction extends BaseAction
{
    /**
     * @var \Domain\Common\Actions\SaveSeoAction
     */
    private SaveSeoAction $saveSeoAction;

    /**
     * @param \Domain\Common\Actions\SaveSeoAction $saveSeoAction
     */
    public function __construct(SaveSeoAction $saveSeoAction)
    {
        $this->saveSeoAction = $saveSeoAction;
    }

    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditCategory\CategoryDTO $categoryDTO
     * @param \Domain\Products\Models\Category|null $target
     *
     * @return \Domain\Products\Models\Category
     */
    public function execute(CategoryDTO $categoryDTO, Category $target = null): Category
    {
        return DB::transaction(function () use ($categoryDTO, $target) {
            $target = $target ?: new Category();

            if ($categoryDTO->name !== null) {
                $target->name = $categoryDTO->name;
            }

            if ($categoryDTO->slug !== null) {
                $target->slug = $categoryDTO->slug;
            }

            if ($categoryDTO->ordering !== null) {
                $target->ordering = $categoryDTO->ordering;
            }

            if ($categoryDTO->is_active !== null) {
                $target->is_active = $categoryDTO->is_active;
            }

            /** @see \Domain\Products\Models\Category::$parent_id */
            $target->setNullableForeignInt('parent_id', $categoryDTO->parent_id);

            /** @see \Domain\Products\Models\Category::$product_type */
            $target->setNullableForeignInt('product_type', $categoryDTO->product_type);

            if ($categoryDTO->description !== null) {
                $target->description = $categoryDTO->description;
            }

            if (! $target->id) {
                $target->save();
            }

            $this->saveSeoAction->execute($target, $categoryDTO->seo);

            $target->save();

            return $target;
        });
    }
}
