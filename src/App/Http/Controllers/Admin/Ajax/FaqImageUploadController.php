<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\FAQs\Models\FAQ;
use Illuminate\Http\Request;

class FaqImageUploadController extends BaseAdminController
{
    public function store(Request $request)
    {
        /** @var \Domain\FAQs\Models\FAQ $faq */
        $faq = $request->admin_faq;
        $request->validate([
            'upload' => 'required|file',
        ]);

        $media = $faq->addMedia($request->file('upload'))->toMediaCollection(FAQ::MC_DESCRIPTION_FILES);

        return [
            'url' => $media->getFullUrl(),
        ];
    }
}
