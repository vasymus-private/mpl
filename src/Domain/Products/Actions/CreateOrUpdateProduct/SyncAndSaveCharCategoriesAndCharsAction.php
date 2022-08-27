<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO;
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
     * @param \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveCharsAction $saveCharsAction
     */
    public function __construct(
        SyncAndSaveCharsAction    $saveCharsAction
    ) {
        $this->saveCharsAction = $saveCharsAction;
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

        $target->load('charCategories.chars');

        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[][] $sorted */
        $sorted = collect($charCategories)->reduce(function(array $acc, CharCategoryDTO $item) use($target) {
            if (! $item->id || $this->isForCopying($target, $item)) {
                $acc['new'][] = $item;

                return $acc;
            }

            $acc['update'][] = $item;

            return $acc;
        }, [
            'new' => [],
            'update' => [],
        ]);

        $notDeleteIds = collect($sorted['update'])->pluck('id')->filter(fn ($id) => (bool)$id)->all();
        $this->delete($target, $notDeleteIds);

        $this->update($target, collect($sorted['update'])->keyBy('id')->all());

        $this->store($target, $sorted['new']);
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
            $charCategory->save();

            $this->saveCharsAction->execute($charCategory, $charCategoryDto->chars);
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO[] $toStore
     *
     * @return void
     */
    private function store(Product $target, array $toStore)
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

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO $charCategoryDTO
     *
     * @return bool
     */
    private function isForCopying(Product $target, CharCategoryDTO $charCategoryDTO): bool
    {
        if (!$charCategoryDTO->id) {
            return false;
        }

        $productCharCategoriesIds = $target->charCategories->pluck('id')->all();

        return !in_array($charCategoryDTO->id, $productCharCategoriesIds);
    }
}
