<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use App\Constants;
use Domain\Common\Actions\BaseAction;
use Domain\Common\Models\CustomMedia;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO;
use Domain\Products\Models\Product\Product;

class SaveMediasAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[] $mediaDTOs
     * @param string $collectionName
     *
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function execute(Product $target, array $mediaDTOs, string $collectionName)
    {
        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[][] $sorted */
        $sorted = collect($mediaDTOs)->reduce(function (array $acc, MediaDTO $item) {
            if ($item->file) {
                $acc['new'][] = $item;

                return $acc;
            }

            if ($this->isForCopying($item)) {
                $acc['copy'][] = $item;

                return $acc;
            }

            if (! $item->id) {
                return $acc;
            }

            $acc['exist'][$item->id] = $item;

            return $acc;
        }, [
            'new' => [],
            'copy' => [],
            'exist' => [],
        ]);

        $notDeleteIds = collect($sorted['exist'])->pluck('id')->filter(fn ($id) => (bool)$id)->all();

        $this->delete($target, $collectionName, $notDeleteIds);

        $this->update($target, $sorted['exist'], $collectionName);

        $this->storeNew($target, $sorted['new'], $collectionName);

        $this->storeCopy($target, $sorted['copy'], $collectionName);
    }

    /**
     * @phpstan-param \Domain\Products\Models\Product\Product $target
     * @phpstan-param array<int,\Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO> $mediaDTOsToUpdate
     * @phpstan-param string $collectionName
     *
     * @return void
     */
    private function update(Product $target, array $mediaDTOsToUpdate, string $collectionName)
    {
        $target->getMedia($collectionName)->each(function (CustomMedia $customMedia) use ($mediaDTOsToUpdate) {
            $updateMediaDTO = $mediaDTOsToUpdate[$customMedia->id] ?? null;
            if (! $updateMediaDTO) {
                return;
            }
            $customMedia->name = $updateMediaDTO->name;
            $customMedia->file_name = $updateMediaDTO->file_name;
            $customMedia->order_column = $updateMediaDTO->order_column;
            $customMedia->save();
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param string $collectionName
     * @param int[] $notDeleteIds
     *
     * @return void
     */
    private function delete(Product $target, string $collectionName, array $notDeleteIds)
    {
        $target->getMedia($collectionName)->each(function (CustomMedia $customMedia) use ($notDeleteIds) {
            if (in_array($customMedia->id, $notDeleteIds)) {
                return;
            }
            $customMedia->delete();
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[] $mediaDTOsNew
     * @param string $collectionName
     *
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function storeNew(Product $target, array $mediaDTOsNew, string $collectionName)
    {
        foreach ($mediaDTOsNew as $mediaDTO) {
            if (! $mediaDTO->file) {
                continue;
            }

            $target
                ->addMedia($mediaDTO->file)
                ->usingFileName($mediaDTO->file_name)
                ->usingName($mediaDTO->name ?? $mediaDTO->file_name)
                ->toMediaCollection($collectionName);
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[] $mediaDTOsCopy
     * @param string $collectionName
     *
     * @return void
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function storeCopy(Product $target, array $mediaDTOsCopy, string $collectionName)
    {
        foreach ($mediaDTOsCopy as $mediaDTO) {
            if (! $this->isForCopying($mediaDTO)) {
                continue;
            }

            /** @var \Domain\Common\Models\CustomMedia|null $original */
            $original = CustomMedia::query()->find($mediaDTO->id);
            if (! $original) {
                continue;
            }

            if (in_array($original->disk, Constants::MEDIA_CLOUD_DISKS)) {
                $remoteUrl = $original->getFullUrl();
                $target
                    ->addMediaFromUrl($remoteUrl)
                    ->usingFileName($mediaDTO->file_name)
                    ->usingName($mediaDTO->name ?? $mediaDTO->file_name)
                    ->toMediaCollection($collectionName);

                continue;
            }

            $target
                ->addMedia($original->getPath())
                ->usingFileName($mediaDTO->file_name)
                ->usingName($mediaDTO->name ?? $mediaDTO->file_name)
                ->toMediaCollection($collectionName);
        }
    }

    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO $mediaDTO
     *
     * @return bool
     */
    private function isForCopying(MediaDTO $mediaDTO): bool
    {
        return $mediaDTO->is_copy && $mediaDTO->id;
    }
}
