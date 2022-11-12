<?php

namespace App\Http\Controllers\Admin;

use Domain\Articles\Models\Article;
use Illuminate\Http\Request;
use Support\H;

class ArticlesController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Articles/Index', [
            'articles' => Article::query()->get(),
        ]);
    }
}
