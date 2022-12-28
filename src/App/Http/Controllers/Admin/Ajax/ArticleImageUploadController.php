<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Articles\Models\Article;
use Illuminate\Http\Request;

class ArticleImageUploadController extends BaseAdminController
{
    public function store(Request $request)
    {
        /** @var \Domain\Articles\Models\Article $article */
        $article = $request->admin_article;
        $request->validate([
            'upload' => 'required|file',
        ]);

        $media = $article->addMedia($request->file('upload'))->toMediaCollection(Article::MC_DESCRIPTION_FILES);

        return [
            'url' => $media->getFullUrl(),
        ];
    }
}
