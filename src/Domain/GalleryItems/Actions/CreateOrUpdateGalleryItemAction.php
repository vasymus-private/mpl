<?php

namespace Domain\GalleryItems\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Actions\SaveSeoAction;
use Domain\Common\Actions\SyncAndSaveMediasAction;
use Domain\Common\DTOs\MediaDTO;
use Domain\GalleryItems\DTOs\GalleryItemDTO;
use Domain\GalleryItems\Models\GalleryItem;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateGalleryItemAction extends BaseAction
{
    /**
     * @var \Domain\Common\Actions\SaveSeoAction
     */
    private SaveSeoAction $saveSeoAction;

    /**
     * @var \Domain\Common\Actions\SyncAndSaveMediasAction
     */
    private SyncAndSaveMediasAction $syncAndSaveMediasAction;

    /**
     * @param \Domain\Common\Actions\SaveSeoAction $saveSeoAction
     * @param \Domain\Common\Actions\SyncAndSaveMediasAction $syncAndSaveMediasAction
     */
    public function __construct(
        SaveSeoAction $saveSeoAction,
        SyncAndSaveMediasAction $syncAndSaveMediasAction,
    )
    {
        $this->saveSeoAction = $saveSeoAction;
        $this->syncAndSaveMediasAction = $syncAndSaveMediasAction;
    }

    /**
     * @param \Domain\GalleryItems\DTOs\GalleryItemDTO $galleryItemDTO
     * @param \Domain\GalleryItems\Models\GalleryItem|null $target
     *
     * @return \Domain\GalleryItems\Models\GalleryItem
     */
    public function execute(GalleryItemDTO $galleryItemDTO, GalleryItem $target = null): GalleryItem
    {
        return DB::transaction(function () use ($galleryItemDTO, $target) {
            $target = $target ?: new GalleryItem();

            if ($galleryItemDTO->name !== null) {
                $target->name = $galleryItemDTO->name;
            }

            if ($galleryItemDTO->slug !== null) {
                $target->slug = $galleryItemDTO->slug;
            }

            if ($galleryItemDTO->is_active !== null) {
                $target->is_active = $galleryItemDTO->is_active;
            }

            if ($galleryItemDTO->parent_id !== null) {
                $target->parent_id = $galleryItemDTO->parent_id !== 0 ? $galleryItemDTO->parent_id : null;
            }

            if ($galleryItemDTO->description !== null) {
                $target->description = $galleryItemDTO->description;
            }

            if (! $target->id) {
                $target->save();
            }

            $this->saveSeoAction->execute($target, $galleryItemDTO->seo);

            $this->saveMainImage($target, $galleryItemDTO->mainImage);

            $target->save();

            return $target;
        });
    }

    /**
     * @param \Domain\GalleryItems\Models\GalleryItem $target
     * @param \Domain\Common\DTOs\MediaDTO|null $mediaDTO
     *
     * @return void
     */
    private function saveMainImage(GalleryItem $target, MediaDTO $mediaDTO = null)
    {
        $this->syncAndSaveMediasAction->execute($target, $mediaDTO ? [ $mediaDTO ] : [], GalleryItem::MC_MAIN_IMAGE);
    }
}
