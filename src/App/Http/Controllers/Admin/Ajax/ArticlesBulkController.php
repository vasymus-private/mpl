<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\ArticlesBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\ArticlesBulkUpdateRequest;
use App\Http\Resources\Admin\ArticleItemResource;
use Domain\Articles\Actions\DeleteArticleAction;
use Domain\Articles\Models\Article;
use Symfony\Component\HttpFoundation\Response;

class ArticlesBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\ArticlesBulkUpdateRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(ArticlesBulkUpdateRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $categoriesToUpdate = Article::query()
            ->whereIn('id', $ids)
            ->get();

        $categoriesToUpdate->each(function (Article $article) use ($payload) {
            $toUpdate = $payload[$article->id];
            $article->forceFill(
                collect($toUpdate->all())
                    ->except(['id'])
                    ->all()
            );
            $article->save();
        });

        return ArticleItemResource::collection(
            Article::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\ArticlesBulkDeleteRequest $request
     * @param \Domain\Articles\Actions\DeleteArticleAction $deleteArticle
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(ArticlesBulkDeleteRequest $request, DeleteArticleAction $deleteArticle)
    {
        $items = Article::query()->whereIn(sprintf('%s.id', Article::TABLE), $request->ids)->get();

        $items->each(function (Article $item) use ($deleteArticle) {
            $deleteArticle->execute($item);
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}
