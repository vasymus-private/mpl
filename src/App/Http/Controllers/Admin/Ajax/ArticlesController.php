<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateArticleRequest;
use App\Http\Resources\Admin\ArticleResource;
use Domain\Articles\Actions\CreateOrUpdateArticleAction;

class ArticlesController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateArticleRequest $request
     * @param \Domain\Articles\Actions\CreateOrUpdateArticleAction $createOrUpdateArticleAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateUpdateArticleRequest $request, CreateOrUpdateArticleAction $createOrUpdateArticleAction)
    {
        $brand = $createOrUpdateArticleAction->execute($request->prepare());

        return new ArticleResource($brand);
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateArticleRequest $request
     * @param \Domain\Articles\Actions\CreateOrUpdateArticleAction $createOrUpdateArticleAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CreateUpdateArticleRequest $request, CreateOrUpdateArticleAction $createOrUpdateArticleAction)
    {
        /** @var \Domain\Articles\Models\Article $target */
        $target = $request->admin_article;

        $article = $createOrUpdateArticleAction->execute($request->prepare(), $target);

        return new ArticleResource($article);
    }
}
