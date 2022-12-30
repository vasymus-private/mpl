<?php

namespace Domain\GalleryItems\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\GalleryItems\Models\GalleryItem;
use Illuminate\Support\Facades\DB;

class DeleteGalleryItemAction extends BaseAction
{
    /**
     * @param \Domain\GalleryItems\Models\GalleryItem $galleryItem
     *
     * @return void
     */
    public function execute(GalleryItem $galleryItem): void
    {
        DB::transaction(function () use ($galleryItem) {
            $galleryItem->children->each(function (GalleryItem $gi) {
                $gi->parent_id = null;
                $gi->save();
            });

            $galleryItem->delete();
        });
    }
}
