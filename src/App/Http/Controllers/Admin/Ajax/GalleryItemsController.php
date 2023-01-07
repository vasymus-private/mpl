<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateGalleryItemsRequest;
use App\Http\Resources\Admin\GalleryItemResource;
use Domain\GalleryItems\Actions\CreateOrUpdateGalleryItemAction;

class GalleryItemsController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateGalleryItemsRequest $request
     * @param \Domain\GalleryItems\Actions\CreateOrUpdateGalleryItemAction $createOrUpdateGalleryItemAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateUpdateGalleryItemsRequest $request, CreateOrUpdateGalleryItemAction $createOrUpdateGalleryItemAction)
    {
        $galleryItem = $createOrUpdateGalleryItemAction->execute($request->prepare());

        return new GalleryItemResource($galleryItem);
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateGalleryItemsRequest $request
     * @param \Domain\GalleryItems\Actions\CreateOrUpdateGalleryItemAction $createOrUpdateGalleryItemAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CreateUpdateGalleryItemsRequest $request, CreateOrUpdateGalleryItemAction $createOrUpdateGalleryItemAction)
    {
        /** @var \Domain\GalleryItems\Models\GalleryItem $target */
        $target = $request->admin_gallery_item;

        $galleryItem = $createOrUpdateGalleryItemAction->execute($request->prepare(), $target);

        return new GalleryItemResource($galleryItem);
    }
}
