<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Products\Models\Brand;
use Illuminate\Http\Request;

class BrandImageUploadController extends BaseAdminController
{
    public function store(Request $request)
    {
        /** @var \Domain\Products\Models\Brand $brand */
        $brand = $request->admin_brand;
        $request->validate([
            'upload' => 'required|file',
        ]);

        $media = $brand->addMedia($request->file('upload'))->toMediaCollection(Brand::MC_DESCRIPTION_FILES);

        return [
            'url' => $media->getFullUrl(),
        ];
    }
}
