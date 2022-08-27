<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Actions\Common\SortToNewCopyUpdateAction;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;

class SyncAndSaveCharsAction extends BaseAction
{
    /**
     * @var \Domain\Products\Actions\Common\SortToNewCopyUpdateAction
     */
    private SortToNewCopyUpdateAction $sortToNewCopyUpdateAction;

    /**
     * @param \Domain\Products\Actions\Common\SortToNewCopyUpdateAction $sortToNewCopyUpdateAction
     */
    public function __construct(SortToNewCopyUpdateAction $sortToNewCopyUpdateAction)
    {
        $this->sortToNewCopyUpdateAction = $sortToNewCopyUpdateAction;
    }

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
        $sorted = $this->sortToNewCopyUpdateAction->execute($chars);

        $notDeleteIds = collect($sorted['update'])->pluck('id')->filter(fn ($id) => (bool)$id)->all();
        $this->delete($charCategory, $notDeleteIds);

        $this->update($charCategory, collect($sorted['update'])->keyBy('id')->all());

        $this->store($charCategory, $sorted['new']);
        $this->store($charCategory, $sorted['copy']);
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
                'type_id' => $charDTO->type_id,
                'category_id' => $charCategory->id,
                'product_id' => $charCategory->product_id,
                'ordering' => $charDTO->ordering,
            ]);
        }
    }
}
