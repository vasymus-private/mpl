<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Product\Product;
use Domain\Products\QueryBuilders\ProductQueryBuilder;
use Illuminate\Http\Request;

class ProductsController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view("admin.pages.products.products");
    }

    public function indexTemp(Request $request)
    {
        $inertia = inertia();
        $inertia->setRootView('admin.layouts.inertia');

        return $inertia->render('Products/Index', [
            'productsPaginated' => Product::query()
                ->select(["*"])
                ->notVariations()
                ->orderByOrderingAndId()
                ->when($request->category_id, fn (ProductQueryBuilder $query, int $categoryId) => $query->forMainAndRelatedCategories([$categoryId]))
                ->when($request->brand_id, fn (ProductQueryBuilder $query, int $brandId) => $query->whereBrandId($brandId))
                ->when($request->search, fn (ProductQueryBuilder $query, string $search) => $query->whereNameOrSlugLike($search))
                ->paginate(),
        ]);
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
