<?php

namespace App\Http\Controllers\Web;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var Article $article*/
        $article = $request->article_slug;

        /** @var Article|null $subarticle */
        $subarticle = $request->subarticle_slug;

        $slug = $subarticle !== null ? $subarticle->slug : $article->slug;

        return view("web.pages.articles.$slug", compact("article", "subarticle"));
    }
}
