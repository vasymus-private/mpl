<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends BaseAdminController
{
    public function index(Request $request)
    {
        $query = Category::query()->select(["*"]);

        if ($request->category_id) {
            $query->where(Category::TABLE . ".parent_id", $request->category_id);
        } else {
            $query->parents();
        }

        if ($request->search) {
            $query->where(Category::TABLE . ".name", "LIKE", "%{$request->search}%");
        }

        $categories = $query->paginate($request->per_page ?? 20);
        $categories->appends($request->query());
    }

    public function create()
    {

    }

    public function edit()
    {

    }
}
