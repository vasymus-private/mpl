<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Product\Product;

class SyncAndSaveInfoPricesAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO[] $infoPriceDTOs
     *
     * @return void
     */
    public function execute(Product $target, array $infoPriceDTOs)
    {
        if (! $target->id) {
            $target->save();
        }

        $target->load('infoPrices');

        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO[][] $sorted */
        $sorted = collect($infoPriceDTOs)->reduce(function (array $acc, InfoPriceDTO $item) use ($target) {
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

        $notDeleteIds = collect($sorted['update'])->pluck('id')->filter(fn ($id) => (bool)$id)->toArray();
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
        $target->infoPrices->each(function (InformationalPrice $informationalPrice) use ($notDeleteIds) {
            if (in_array($informationalPrice->id, $notDeleteIds)) {
                return;
            }

            $informationalPrice->delete();
        });
    }

    /**
     * @phpstan-param \Domain\Products\Models\Product\Product $target
     * @phpstan-param array<int, \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO> $toUpdate
     *
     * @return void
     */
    private function update(Product $target, array $toUpdate)
    {
        $target->infoPrices->each(function (InformationalPrice $informationalPrice) use ($toUpdate) {
            $infoPriceDTO = $toUpdate[$informationalPrice->id] ?? null;
            if (! $infoPriceDTO) {
                return;
            }

            $informationalPrice->name = $infoPriceDTO->name;
            $informationalPrice->price = $infoPriceDTO->price;

            $informationalPrice->save();
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO[] $toStore
     *
     * @return void
     */
    private function store(Product $target, array $toStore)
    {
        foreach ($toStore as $infoPriceDTO) {
            InformationalPrice::forceCreate([
                'name' => $infoPriceDTO->name,
                'price' => $infoPriceDTO->price,
                'product_id' => $target->id,
            ]);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO $item
     *
     * @return bool
     */
    private function isForCopying(Product $target, InfoPriceDTO $item): bool
    {
        if (! $item->id) {
            return false;
        }

        $ids = $target->infoPrices->pluck('id')->all();

        return ! in_array($item->id, $ids);
    }
}
