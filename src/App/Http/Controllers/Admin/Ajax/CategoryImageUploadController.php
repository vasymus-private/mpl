<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Products\Models\Category;
use Illuminate\Http\Request;

class CategoryImageUploadController extends BaseAdminController
{
    public function store(Request $request)
    {
        /** @var \Domain\Products\Models\Category $category */
        $category = $request->admin_category;
        $request->validate([
            'upload' => 'required|file',
        ]);

        $media = $category->addMedia($request->file('upload'))->toMediaCollection(Category::MC_DESCRIPTION_FILES);

        return [
            'url' => $media->getFullUrl(),
        ];
    }
}
