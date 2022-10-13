<?php

namespace Domain\Common\Actions;

use Domain\Common\DTOs\MediaDTO;
use Domain\Common\Models\CustomMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SyncAndSaveMediasAction extends BaseAction
{
    private const ORDERING_STEP = 100;

    /**
     * @param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Orders\Models\Order $target
     * @param \Domain\Common\DTOs\MediaDTO[] $mediaDTOs
     * @param string $collectionName
     *
     * @return void
     */
    public function execute($target, array $mediaDTOs, string $collectionName)
    {
        if (! $target->id) {
            $target->save();
        }

        $target->load('media');

        $mediaDTOs = $this->getWithUpdatedOrderingColumnAccordingArrayOrder($mediaDTOs);

        /** @var \Domain\Common\DTOs\MediaDTO[][] $sorted */
        $sorted = collect($mediaDTOs)->reduce(function (array $acc, MediaDTO $item) use ($target, $collectionName) {
            if ($item->file) {
                $acc['file'][] = $item;

                return $acc;
            }

            if ($this->isForCopying($target, $collectionName, $item)) {
                $acc['copy'][] = $item;

                return $acc;
            }

            if ($item->id) {
                $acc['update'][] = $item;

                return $acc;
            }

            return $acc;
        }, [
            'file' => [],
            'copy' => [],
            'update' => [],
        ]);

        $notDeleteIds = collect($sorted['update'])->pluck('id')->filter(fn ($id) => (bool)$id)->all();

        $this->delete($target, $collectionName, $notDeleteIds);

        $this->update($target, collect($sorted['update'])->keyBy('id')->all(), $collectionName);

        $this->storeFile($target, $sorted['file'], $collectionName);

        $this->storeCopy($target, $sorted['copy'], $collectionName);
    }

    /**
     * @param \Domain\Common\DTOs\MediaDTO[] $mediaDTOs
     *
     * @return \Domain\Common\DTOs\MediaDTO[]
     */
    private function getWithUpdatedOrderingColumnAccordingArrayOrder(array $mediaDTOs): array
    {
        $ordering = 0;

        return collect($mediaDTOs)
            ->map(function(MediaDTO $mediaDTO) use (&$ordering) {
                $mediaDTO->order_column = ($ordering += static::ORDERING_STEP);

                return $mediaDTO;
            })
            ->sortBy('ordering')
            ->values()
            ->all();
    }

    /**
     * @param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Orders\Models\Order $target
     * @param string $collectionName
     * @param int[] $notDeleteIds
     *
     * @return void
     */
    private function delete($target, string $collectionName, array $notDeleteIds)
    {
        $target->getMedia($collectionName)->each(function (CustomMedia $customMedia) use ($notDeleteIds) {
            if (in_array($customMedia->id, $notDeleteIds)) {
                return;
            }

            $customMedia->delete();
        });
    }

    /**
     * @phpstan-param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Orders\Models\Order $target
     * @phpstan-param array<int,\Domain\Common\DTOs\MediaDTO> $mediaDTOsToUpdate
     * @phpstan-param string $collectionName
     *
     * @return void
     */
    private function update($target, array $mediaDTOsToUpdate, string $collectionName)
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
     * @param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Orders\Models\Order $target
     * @param \Domain\Common\DTOs\MediaDTO[] $mediaDTOsNew
     * @param string $collectionName
     *
     * @return void
     */
    private function storeFile($target, array $mediaDTOsNew, string $collectionName)
    {
        foreach ($mediaDTOsNew as $mediaDTO) {
            if (! $mediaDTO->file) {
                continue;
            }

            try {
                $target
                    ->addMedia($mediaDTO->file)
                    ->usingFileName($mediaDTO->file_name)
                    ->usingName($mediaDTO->name ?? $mediaDTO->file_name)
                    ->toMediaCollection($collectionName);
            } catch (FileDoesNotExist|FileIsTooBig $ignored) {
            }
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Orders\Models\Order $target
     * @param \Domain\Common\DTOs\MediaDTO[] $mediaDTOsCopy
     * @param string $collectionName
     *
     * @return void
     */
    private function storeCopy($target, array $mediaDTOsCopy, string $collectionName)
    {
        foreach ($mediaDTOsCopy as $mediaDTO) {
            /** @var \Domain\Common\Models\CustomMedia|null $original */
            $original = CustomMedia::query()->find($mediaDTO->id);
            if (! $original) {
                continue;
            }

            try {
                if ($original->is_on_cloud) {
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
            } catch (FileCannotBeAdded|FileDoesNotExist|FileIsTooBig $ignored) {
            }
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product|\Domain\Products\Models\Brand|\Domain\Orders\Models\Order $target
     * @param string $collectionName
     * @param \Domain\Common\DTOs\MediaDTO $mediaDTO
     *
     * @return bool
     */
    private function isForCopying($target, string $collectionName, MediaDTO $mediaDTO): bool
    {
        if (! $mediaDTO->id) {
            return false;
        }

        $mediaIds = $target->getMedia($collectionName)->pluck('id')->all();

        return ! in_array($mediaDTO->id, $mediaIds);
    }
}
