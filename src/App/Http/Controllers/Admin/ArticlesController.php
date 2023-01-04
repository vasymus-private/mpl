<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\ArticleItemResource;
use App\Http\Resources\Admin\ArticleResource;
use Domain\Articles\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\H;

class ArticlesController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = Article::query();

        if ($request->search) {
            $query->where(function (Builder $q) use ($request) {
                $q->where(sprintf('%s.name', Article::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.description', Article::TABLE), "LIKE", "%{$request->search}%");
            });
        }

        return $inertia->render('Articles/Index', [
            'articles' => ArticleItemResource::collection($query->paginate($request->per_page)),
        ]);
    }

    public function create(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Articles/CreateEdit');
    }

    public function edit(Request $request)
    {
        $inertia = H::getAdminInertia();

        /** @var \Domain\Articles\Models\Article $article */
        $article = $request->admin_article;

        return $inertia->render('Articles/CreateEdit', [
            'article' => (new ArticleResource($article))->toArray($request),
        ]);
    }
}
