<?php

namespace App\Http\Controllers\Web;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticlesController extends BaseWebController
{
    public function show(Request $request)
    {
        $categories = Category::parents()->with("subcategories.subcategories.subcategories")->orderBy(Category::TABLE . ".ordering")->get();

        /** @var Article $article*/
        $article = $request->article_slug;

        /** @var Article|null $subarticle */
        $subarticle = $request->subarticle_slug;

        $slug = $subarticle !== null ? $subarticle->slug : $article->slug;

        return view("web.articles.$slug", compact("article", "subarticle", "categories"));
    }
}
