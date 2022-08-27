<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Actions\DeleteVariationAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO;
use Domain\Products\Models\Product\Product;

class SyncAndSaveVariationsAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO[] $variations
     *
     * @return void
     */
    public function execute(Product $target, array $variations)
    {
        if (!$target->id) {
            $target->save();
        }

        $target->load('variations');

        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO[][] $sorted */
        $sorted = collect($variations)->reduce(function(array $acc, VariationDTO $item) use($target) {
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

        $notDeleteIds = collect($sorted['update'])->pluck('id')->filter(fn($id) => (bool)$id)->all();
        $this->delete($target, $notDeleteIds);

        $this->update($target, collect($sorted['update'])->keyBy('id')->all());
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param int[] $notDeleteIds
     *
     * @return void
     */
    private function delete(Product $target, array $notDeleteIds)
    {
        $target->variations->each(function(Product $variation) use ($notDeleteIds) {
            if (in_array($variation->id, $notDeleteIds)) {
                return;
            }

            DeleteVariationAction::cached()->execute($variation);
        });
    }

    /**
     * @phpstan-param \Domain\Products\Models\Product\Product $target
     * @phpstan-param array<int, \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO> $toUpdate
     *
     * @return void
     */
    private function update(Product $target, array $toUpdate)
    {
        $target->variations->each(function(Product $variation) use ($toUpdate) {
            $variationDto = $toUpdate[$variation->id] ?? null;
            if (!$variationDto) {
                return;
            }

            $variation->name = $variationDto->name;
            // todo
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO $item
     *
     * @return bool
     */
    private function isForCopying(Product $target, VariationDTO $item): bool
    {
        if (! $item->id) {
            return false;
        }

        $ids = $target->variations->pluck('id')->all();

        return ! in_array($item->id, $ids);
    }
}
