<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;

class SyncAndSaveCharsAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\CharCategory $charCategory
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[] $chars
     *
     * @return void
     */
    public function execute(CharCategory $charCategory, array $chars)
    {
        if (! $charCategory->id) {
            $charCategory->save();
        }

        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[][] $sorted */
        $sorted = collect($chars)->reduce(function (array $acc, CharDTO $item) use ($charCategory) {
            if (! $item->id || $this->isForCopying($charCategory, $item)) {
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

        $this->delete($charCategory, $notDeleteIds);

        $this->update($charCategory, collect($sorted['update'])->keyBy('id')->all());

        $this->store($charCategory, $sorted['new']);
    }

    /**
     * @param \Domain\Products\Models\CharCategory $charCategory
     * @param int[] $notDeleteIds
     *
     * @return void
     */
    private function delete(CharCategory $charCategory, array $notDeleteIds)
    {
        $charCategory->chars->each(function (Char $char) use ($notDeleteIds) {
            if (in_array($char->id, $notDeleteIds)) {
                return;
            }

            $char->delete();
        });
    }

    /**
     * @phpstan-param \Domain\Products\Models\CharCategory $charCategory
     * @phpstan-param array<int, \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO> $toUpdate
     *
     * @return void
     */
    private function update(CharCategory $charCategory, array $toUpdate)
    {
        $charCategory->chars->each(function (Char $char) use ($toUpdate) {
            $charDto = $toUpdate[$char->id] ?? null;
            if (! $charDto) {
                return;
            }

            $char->name = $charDto->name;
            $char->value = $charDto->value;
            $char->save();
        });
    }

    /**
     * @param \Domain\Products\Models\CharCategory $charCategory
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO[] $toStore
     *
     * @return void
     */
    private function store(CharCategory $charCategory, array $toStore)
    {
        foreach ($toStore as $charDTO) {
            Char::forceCreate([
                'name' => $charDTO->name,
                'value' => $charDTO->value,
                'type_id' => $charDTO->type_id ?? Char::DEFAULT_TYPE,
                'category_id' => $charCategory->id,
                'product_id' => $charCategory->product_id,
                'ordering' => $charDTO->ordering ?? Char::DEFAULT_ORDERING,
            ]);
        }
    }

    private function isForCopying(CharCategory $charCategory, CharDTO $charDTO): bool
    {
        if (! $charDTO->id) {
            return false;
        }

        $charIds = $charCategory->chars->pluck('id')->all();

        return ! in_array($charDTO->id, $charIds);
    }
}
