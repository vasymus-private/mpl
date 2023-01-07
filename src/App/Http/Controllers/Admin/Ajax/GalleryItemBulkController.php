<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\GalleryItemBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\GalleryItemBulkUpdateRequest;
use App\Http\Resources\Admin\GalleryItemListItemResource;
use Domain\GalleryItems\Actions\DeleteGalleryItemAction;
use Domain\GalleryItems\Models\GalleryItem;
use Symfony\Component\HttpFoundation\Response;

class GalleryItemBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\GalleryItemBulkUpdateRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(GalleryItemBulkUpdateRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $categoriesToUpdate = GalleryItem::query()
            ->whereIn('id', $ids)
            ->get();

        $categoriesToUpdate->each(function (GalleryItem $galleryItem) use ($payload) {
            $toUpdate = $payload[$galleryItem->id];
            $galleryItem->forceFill(
                collect($toUpdate->all())
                    ->except(['id'])
                    ->all()
            );
            $galleryItem->save();
        });

        return GalleryItemListItemResource::collection(
            GalleryItem::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\GalleryItemBulkDeleteRequest $request
     * @param \Domain\GalleryItems\Actions\DeleteGalleryItemAction $deleteGalleryItemAction
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(GalleryItemBulkDeleteRequest $request, DeleteGalleryItemAction $deleteGalleryItemAction)
    {
        $items = GalleryItem::query()->whereIn(sprintf('%s.id', GalleryItem::TABLE), $request->ids)->get();

        $items->each(function (GalleryItem $item) use ($deleteGalleryItemAction) {
            $deleteGalleryItemAction->execute($item);
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}
