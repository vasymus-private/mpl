<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\CategoryItemResource;
use App\Http\Resources\Admin\CategoryResource;
use Domain\Products\Models\Category;
use Domain\Products\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Http\Request;
use Support\H;

class CategoriesController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view('admin.pages.categories.categories');
    }

    public function indexTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = Category::query()
            ->select(["*"])
            ->when($request->product_type, fn(CategoryQueryBuilder $query, int $product_type) => $query->where('product_type', $product_type))
            ->ordering()
            ->with('subcategories');

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
            'categories' => CategoryItemResource::collection($query->get()),
        ]);
    }

    public function create()
    {
        $category = new Category();

        return view('admin.pages.categories.category', compact('category'));
    }

    public function createTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

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
        $inertia = H::getAdminInertia();

        /** @var \Domain\Products\Models\Category $category */
        $category = $request->admin_category;

        return $inertia->render('Categories/CreateEdit', [
            'category' => (new CategoryResource($category))->toArray($request),
        ]);
    }
}
