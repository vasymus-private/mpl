<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view('admin.pages.categories.categories');
    }

    public function indexTemp(Request $request)
    {
        $inertia = inertia();
        $inertia->setRootView('admin.layouts.inertia');

        $query = Category::query()->select(["*"])->with('subcategories');

        if (! $request->category_id) {
            $query->parents();
        }

        if ($request->category_id && $request->category_id !== 'all') {
            $query->where(Category::TABLE . ".parent_id", $request->category_id);
        }

        if ($request->search) {
            $query->where(Category::TABLE . ".name", "LIKE", "%{$request->search}%");
        }

        return $inertia->render('Categories/Index', [
            '',
        ]);
    }

    public function create()
    {
        $category = new Category();

        return view('admin.pages.categories.category', compact('category'));
    }

    public function createTemp(Request $request)
    {
        $inertia = inertia();
        $inertia->setRootView('admin.layouts.inertia');

        return $inertia->render('Categories/CreateEdit');
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Products\Models\Category $category */
        $category = $request->admin_category;

        return view('admin.pages.categories.category', compact('category'));
    }

    public function editTemp(Request $request)
    {
        $inertia = inertia();
        $inertia->setRootView('admin.layouts.inertia');

        /** @var \Domain\Products\Models\Category $category */
        $category = $request->admin_category;

        return $inertia->render('Categories/CreateEdit', compact('category'));
    }
}
