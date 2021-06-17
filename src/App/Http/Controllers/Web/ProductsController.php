<?php

namespace App\Http\Controllers\Web;

use Domain\Products\Actions\FiltrateByCategoriesAction;
use Domain\Products\DTOs\FiltrateByCategoriesParamsDTO;
use Domain\Products\Events\ProductViewedEvent;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Support\Breadcrumbs\Breadcrumbs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Support\H;

class ProductsController extends BaseWebController
{
    public function index(Request $request, FiltrateByCategoriesAction $filtrateByCategoriesAction)
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

        $query = $filtrateByCategoriesAction->execute($query, new FiltrateByCategoriesParamsDTO(compact("category", "subcategory1", "subcategory2", "subcategory3")));

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

        $user = H::userOrAdmin();
        event(new ProductViewedEvent($user, $product));

        $product->load(["seo", "variations.parent", "brand", "accessory.category.parentCategory.parentCategory.parentCategory", "similar.category.parentCategory.parentCategory.parentCategory", "related.category.parentCategory.parentCategory.parentCategory", "works.category.parentCategory.parentCategory.parentCategory", "charCategories.chars"]);

        $breadcrumbs = Breadcrumbs::productRoute($product, $category, $subcategory1, $subcategory2, $subcategory3);
        $seoArr = null;
        if ($product->seo) {
            $seoArr = [
                'title' => $product->seo->title ?? null,
                'keywords' => $product->seo->keywords ?? null,
                'description' => $product->seo->description ?? null,
            ];
        }

        return view("web.pages.products.product", compact("product", "breadcrumbs", "seoArr"));
    }
}
