<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Actions\Common\CheckIsForCopyingAction;
use Domain\Products\Actions\Common\SortToNewCopyUpdateAction;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
use Domain\Products\Models\Product\Product;

class SyncAndSaveCharCategoriesAndCharsAction extends BaseAction
{
    /**
     * @var \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveCharsAction
     */
    private SyncAndSaveCharsAction $saveCharsAction;

    /**
     * @var \Domain\Products\Actions\Common\CheckIsForCopyingAction
     */
    private CheckIsForCopyingAction $checkIsForCopyingAction;

    /**
     * @var \Domain\Products\Actions\Common\SortToNewCopyUpdateAction
     */
    private SortToNewCopyUpdateAction $sortToNewCopyUpdateAction;

    /**
     * @param \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveCharsAction $saveCharsAction
     * @param \Domain\Products\Actions\Common\CheckIsForCopyingAction $checkIsForCopyingAction
     * @param \Domain\Products\Actions\Common\SortToNewCopyUpdateAction $sortToNewCopyUpdateAction
     */
    public function __construct(
        SyncAndSaveCharsAction    $saveCharsAction,
        CheckIsForCopyingAction   $checkIsForCopyingAction,
        SortToNewCopyUpdateAction $sortToNewCopyUpdateAction
    ) {
        $this->saveCharsAction = $saveCharsAction;
        $this->checkIsForCopyingAction = $checkIsForCopyingAction;
        $this->sortToNewCopyUpdateAction = $sortToNewCopyUpdateAction;
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[] $charCategories
     *
     * @return void
     */
    public function execute(Product $target, array $charCategories)
    {
        if (! $target->id) {
            $target->save();
        }

        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[][] $sorted */
        $sorted = $this->sortToNewCopyUpdateAction->execute($charCategories);

        $notDeleteIds = collect($sorted['update'])->pluck('id')->filter(fn ($id) => (bool)$id)->all();
        $this->delete($target, $notDeleteIds);

        $this->update($target, collect($sorted['update'])->keyBy('id')->all());

        $this->storeNew($target, $sorted['new']);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param int[] $notDeleteIds
     *
     * @return void
     */
    private function delete(Product $target, array $notDeleteIds)
    {
        $target->charCategories->each(function (CharCategory $charCategory) use ($notDeleteIds) {
            if (in_array($charCategory->id, $notDeleteIds)) {
                return;
            }
            $charCategory->chars->each(function (Char $char) {
                $char->delete();
            });
            $charCategory->delete();
        });
    }

    /**
     * @phpstan-param \Domain\Products\Models\Product\Product $target
     * @phpstan-param array<int, \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO> $toUpdate
     *
     * @return void
     */
    private function update(Product $target, array $toUpdate)
    {
        $target->charCategories->each(function (CharCategory $charCategory) use ($target, $toUpdate) {
            $charCategoryDto = $toUpdate[$charCategory->id] ?? null;
            if (! $charCategoryDto) {
                return;
            }

            $charCategory->name = $charCategoryDto->name;
            $charCategory->ordering = $charCategoryDto->ordering;

            $this->saveCharsAction->execute($charCategory, $charCategoryDto->chars);
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[] $toStore
     *
     * @return void
     */
    private function storeNew(Product $target, array $toStore)
    {
        foreach ($toStore as $charCategoryDTO) {
            $charCategory = CharCategory::forceCreate([
                'name' => $charCategoryDTO->name,
                'product_id' => $target->id,
                'ordering' => $charCategoryDTO->ordering,
            ]);

            $this->saveCharsAction->execute($charCategory, $charCategoryDTO->chars);
        }
    }
}
