<?php

namespace App\Http\Controllers\Web;

use Domain\Articles\Models\Article;
use App\Services\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

class ArticlesController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var \Domain\Articles\Models\Article $article*/
        $article = $request->article_slug;

        /** @var Article|null $subarticle */
        $subarticle = $request->subarticle_slug;

        $slug = $subarticle !== null ? $subarticle->slug : $article->slug;

        $breadcrumbs = Breadcrumbs::articleRoute($article, $subarticle);

        return view("web.pages.articles.$slug", compact("article", "subarticle", "breadcrumbs"));
    }
}
