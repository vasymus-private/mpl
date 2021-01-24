<?php

namespace App\Http\Controllers\Web;

use App\Events\ProductViewedEvent;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use App\Services\Breadcrumbs\Breadcrumbs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProductsController extends BaseWebController
{
    public function index(Request $request)
    {
        $query = Product::query()->notVariations()->with("infoPrices");

        /** @var \Domain\Products\Models\Category|null $category */
        $category = $request->category_slug;
        /** @var Category|null $subcategory1 */
        $subcategory1 = $request->subcategory1_slug;
        /** @var Category|null $subcategory2 */
        $subcategory2 = $request->subcategory2_slug;
        /** @var \Domain\Products\Models\Category|null $subcategory3 */
        $subcategory3 = $request->subcategory3_slug;

        foreach ([$subcategory3, $subcategory2, $subcategory1, $category] as $cat) {
            /** @var \Domain\Products\Models\Category $cat*/
            if ($cat) {
                $query->where(Product::TABLE . ".category_id", $cat->id);
                break;
            }
        }

        if (!empty($request->input("brands", []))) {
            $query->whereIn(Product::TABLE . ".brand_id", $request->input("brands"));
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

        $query->with([
            "category.parentCategory.parentCategory.parentCategory",
        ]);

        /** @var LengthAwarePaginator $products */
        $products = $query->paginate(
            $request->input("per_page")
        );

        $productIds = $queryWithoutPagination->pluck("id")->toArray();

        $breadcrumbs = Breadcrumbs::productsRoute($category, $subcategory1, $subcategory2, $subcategory3);

        $entity = $subcategory3 ?? $subcategory2 ?? $subcategory1 ?? $category ?? null;

        return view("web.pages.products.products", compact("productIds", "products", "breadcrumbs", "entity"));
    }

    public function show(Request $request)
    {
        /** @var \Domain\Products\Models\Category $category */
        $category = $request->category_slug;
        /** @var \Domain\Products\Models\Category|null $subcategory1 */
        $subcategory1 = $request->subcategory1_slug;
        /** @var \Domain\Products\Models\Category|null $subcategory2 */
        $subcategory2 = $request->subcategory2_slug;
        /** @var Category|null $subcategory3 */
        $subcategory3 = $request->subcategory3_slug;

        /** @var Product $product */
        $product = $request->product_slug;

        event(new ProductViewedEvent(Auth::user(), $product));

        $product->load(["variations.parent", "brand", "accessory.category.parentCategory.parentCategory.parentCategory", "similar.category.parentCategory.parentCategory.parentCategory", "related.category.parentCategory.parentCategory.parentCategory", "works.category.parentCategory.parentCategory.parentCategory"]);

        $breadcrumbs = Breadcrumbs::productRoute($product, $category, $subcategory1, $subcategory2, $subcategory3);

        return view("web.pages.products.product", compact("product", "breadcrumbs"));
    }
}
