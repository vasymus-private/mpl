<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductsController extends BaseAdminController
{
    public function index(Request $request)
    {
        $query = Product::query()->select(["*"])->notVariations();
        $table = Product::TABLE;

        $category = null;

        if ($request->category_id) {
            $category = Category::query()->find($request->category_id);
            $query->where("$table.category_id", $request->category_id);
        }

        if ($request->search) {
            $query->where("$table.name", "LIKE", "%{$request->search}%");
        }

        $products = $query->paginate($request->per_page ?? 20);
        $products->appends($request->query());

        return view("admin.pages.products.products", compact("products", "category"));
    }

    public function create(Request $request)
    {
        $product = new Product();

        return view("admin.pages.products.product", compact("product"));
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = $request->admin_product;
        $product->load(['infoPrices', 'media', 'accessory', 'similar', 'related', 'works', 'instruments']);

        return view("admin.pages.products.product", compact("product"));
    }
}
