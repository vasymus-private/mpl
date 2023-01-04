<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\GalleryItemListItemResource;
use App\Http\Resources\Admin\GalleryItemResource;
use Domain\GalleryItems\Models\GalleryItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\H;

class GalleryItemsController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = GalleryItem::query()->select(["*"]);

        if ($request->search) {
            $query->where(function (Builder $q) use ($request) {
                $q->where(sprintf('%s.name', GalleryItem::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.description', GalleryItem::TABLE), "LIKE", "%{$request->search}%");
            });
        }

        return $inertia->render('GalleryItem/Index', [
            'galleryItems' => GalleryItemListItemResource::collection($query->paginate($request->per_page)),
        ]);
    }

    public function create(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('GalleryItem/CreateEdit');
    }

    public function edit(Request $request)
    {
        $inertia = H::getAdminInertia();

        /** @var \Domain\GalleryItems\Models\GalleryItem $galleryItem */
        $galleryItem = $request->admin_gallery_item;

        return $inertia->render('GalleryItem/CreateEdit', [
            'galleryItem' => (new GalleryItemResource($galleryItem))->toArray($request),
        ]);
    }
}
