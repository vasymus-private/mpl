<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HelperController extends BaseAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function slug(Request $request): array
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'separator' => 'string|nullable',
            'language' => 'string|nullable',
        ]);

        return [
            'data' => Str::slug($validated['title'], $validated['separator'] ?? '-', $validated['language'] ?? 'en'),
        ];
    }
}
