<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductsController extends BaseWebController
{
    public function index(Request $request)
    {
        $categories = Category::parents()->with("subcategories.subcategories.subcategories")->get();

        $query = Product::query();

        if (!empty($request->input("manufacturers", []))) {
            $query->whereIn(Product::TABLE . ".manufacturer_id", $request->input("manufacturers"));
        }

        if (!empty($request->search)) {
            $query->where(function(Builder $builder) use($request) {
                $builder
                    ->orWhere(Product::TABLE . ".name", "like", "%{$request->search}%")
                    ->orWhere(Product::TABLE . ".preview", "like", "%{$request->search}%")
                    ->orWhere(Product::TABLE . ".description", "like", "%{$request->search}%")
                ;
            });
        }

        $products = $query->paginate(
            $request->input("per_page", 20)
        );

        $productIds = $query->pluck("id");

        $manufacturers = Manufacturer
                        ::query()
                        ->withCount([
                            "products" => function(Builder $builder) use($productIds) {
                                return $builder->where(Product::TABLE . ".id", $productIds);
                            },
                        ])
                        ->having("products_count", ">", 0)
                        ->get()
        ;

        return view("web.products", compact("categories", "manufacturers", "products"));
    }

    public function show(Request $request)
    {

        return view("test");
    }
}
