<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductsController extends BaseAdminController
{
    public function index(Request $request)
    {
        $query = Product::query()->select(["*"])->notVariations();
        $table = Product::TABLE;

        if ($request->category_id) {
            $query->where("$table.category_id", $request->category_id);
        }

        if ($request->search) {
            $query->where("$table.name", "LIKE", "%{$request->search}%");
        }

        $products = $query->paginate($request->per_page ?? 20);
        $products->appends($request->query());

        return view("admin.pages.products.products", compact("products"));
    }

    public function show(Request $request)
    {

    }
}
