<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductImageUploadController extends BaseAdminController
{
    public function store(Request $request)
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = $request->admin_product;
        $request->validate([
            'upload' => 'required|file'
        ]);

        $media = $product->addMedia($request->file('upload'))->toMediaCollection(Product::MC_DESCRIPTION_FILES);
        return [
            'url' => $media->getFullUrl(),
        ];
    }
}
