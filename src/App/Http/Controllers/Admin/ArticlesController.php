<?php

namespace App\Http\Controllers\Admin;

use Domain\Articles\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = inertia();
        $inertia->setRootView('admin.layouts.inertia');

        return $inertia->render('Articles/Index', [
            'articles' => Article::query()->get(),
        ]);
    }
}
