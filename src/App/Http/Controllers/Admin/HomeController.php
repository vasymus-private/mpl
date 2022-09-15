<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\H;

class HomeController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view("admin.pages.home.home");
    }

    public function indexTemp()
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Dashboard/Index');
    }

    public function media(Request $request)
    {
        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
        $media = Media::query()->findOrFail($request->id);

        return $media->toResponse($request);
    }
}
