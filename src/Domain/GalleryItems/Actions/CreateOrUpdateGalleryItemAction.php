<?php

namespace Domain\GalleryItems\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Actions\SaveSeoAction;
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
     * @param \Domain\Common\Actions\SaveSeoAction $saveSeoAction
     */
    public function __construct(SaveSeoAction $saveSeoAction)
    {
        $this->saveSeoAction = $saveSeoAction;
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

            $target->save();

            return $target;
        });
    }
}
