<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Actions\DeleteVariationAction;
use Domain\Common\Actions\SyncAndSaveMediasAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO;
use Domain\Products\Models\Product\Product;

class SyncAndSaveVariationsAction extends BaseAction
{
    /**
     * @var \Domain\Common\Actions\SyncAndSaveMediasAction
     */
    private SyncAndSaveMediasAction $syncAndSaveMediasAction;

    /**
     * @param \Domain\Common\Actions\SyncAndSaveMediasAction $syncAndSaveMediasAction
     */
    public function __construct(SyncAndSaveMediasAction $syncAndSaveMediasAction)
    {
        $this->syncAndSaveMediasAction = $syncAndSaveMediasAction;
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO[] $variations
     *
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function execute(Product $target, array $variations)
    {
        if (! $target->id) {
            $target->save();
        }

        $target->load('variations');

        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO[][] $sorted */
        $sorted = collect($variations)->reduce(function (array $acc, VariationDTO $item) use ($target) {
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
        $target->variations->each(function (Product $variation) use ($notDeleteIds) {
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
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function update(Product $target, array $toUpdate)
    {
        $target->variations->each(function (Product $variation) use ($toUpdate) {
            $variationDTO = $toUpdate[$variation->id] ?? null;
            if (! $variationDTO) {
                return;
            }

            $variation->name = $variationDTO->name;
            $variation->is_active = $variationDTO->is_active;
            $variation->ordering = $variationDTO->ordering;
            $variation->coefficient = $variationDTO->coefficient;
            $variation->coefficient_description = $variationDTO->coefficient_description;
            $variation->unit = $variationDTO->unit;
            $variation->availability_status_id = $variationDTO->availability_status_id;
            $variation->price_purchase = $variationDTO->price_purchase;
            $variation->price_purchase_currency_id = $variationDTO->price_purchase_currency_id;
            $variation->price_retail = $variationDTO->price_retail;
            $variation->price_retail_currency_id = $variationDTO->price_retail_currency_id;
            $variation->preview = $variationDTO->preview;

            $this->syncAndSaveMediasAction->execute($variation, $variationDTO->mainImage ? [$variationDTO->mainImage] : [], Product::MC_MAIN_IMAGE);

            $this->syncAndSaveMediasAction->execute($variation, $variationDTO->additionalImages, Product::MC_ADDITIONAL_IMAGES);
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO[] $toStore
     *
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function store(Product $target, array $toStore)
    {
        foreach ($toStore as $variationDTO) {
            $variation = Product::forceCreate([
                'parent_id' => $target->id,
                'name' => $variationDTO->name,
                'is_active' => $variationDTO->is_active,
                'ordering' => $variationDTO->ordering,
                'coefficient' => $variationDTO->coefficient,
                'coefficient_description' => $variationDTO->coefficient_description,
                'unit' => $variationDTO->unit,
                'availability_status_id' => $variationDTO->availability_status_id,
                'price_purchase' => $variationDTO->price_purchase,
                'price_purchase_currency_id' => $variationDTO->price_purchase_currency_id,
                'price_retail' => $variationDTO->price_retail,
                'price_retail_currency_id' => $variationDTO->price_retail_currency_id,
                'preview' => $variationDTO->preview,
            ]);

            $this->syncAndSaveMediasAction->execute($variation, $variationDTO->mainImage ? [$variationDTO->mainImage] : [], Product::MC_MAIN_IMAGE);

            $this->syncAndSaveMediasAction->execute($variation, $variationDTO->additionalImages, Product::MC_ADDITIONAL_IMAGES);
        }
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
