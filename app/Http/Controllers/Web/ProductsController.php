<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsController extends BaseWebController
{
    public function index(Request $request)
    {
        $query = Product::query();

        /** @var Category|null $category */
        $category = $request->category_slug;
        /** @var Category|null $subcategory1 */
        $subcategory1 = $request->subcategory1_slug;
        /** @var Category|null $subcategory2 */
        $subcategory2 = $request->subcategory2_slug;
        /** @var Category|null $subcategory3 */
        $subcategory3 = $request->subcategory3_slug;

        foreach ([$subcategory3, $subcategory2, $subcategory1, $category] as $cat) {
            /** @var Category $cat*/
            if ($cat) {
                $query->where(Product::TABLE . ".category_id", $cat->id);
                break;
            }
        }

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

        $queryWithoutPagination = clone $query;

        /** @var LengthAwarePaginator $products */
        $products = $query->paginate(
            $request->input("per_page", 20)
        );

        $productIds = $queryWithoutPagination->pluck("id")->toArray();

        $breadcrumbs = [];
        if ($category) {
            $breadcrumbs[] = [
                "name" => $category->name,
                "href" => route("products.index", [$category->slug]),
            ];
        }
        if ($subcategory1) {
            $breadcrumbs[] = [
                "name" => $subcategory1->name,
                "href" => route("products.index", [$category->slug, $subcategory1->slug]),
            ];
        }
        if ($subcategory2) {
            $breadcrumbs[] = [
                "name" => $subcategory2->name,
                "href" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug]),
            ];
        }
        if ($subcategory3) {
            $breadcrumbs[] = [
                "name" => $subcategory3->name,
                "href" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug, $subcategory3->slug]),
            ];
        }

        $subtitle = $subcategory3->name ?? $subcategory2->name ?? $subcategory1->name ?? $category->name ?? null;

        return view("web.pages.products.products", compact("productIds", "products", "breadcrumbs", "subtitle"));
    }

    public function show(Request $request)
    {

        return view("test");
    }
}
