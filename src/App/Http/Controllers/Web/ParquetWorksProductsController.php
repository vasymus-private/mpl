<?php

namespace App\Http\Controllers\Web;

use Domain\Products\Events\ProductViewedEvent;
use Illuminate\Http\Request;
use Support\Breadcrumbs\Breadcrumbs;
use Support\H;

class ParquetWorksProductsController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = $request->parquet_works_product_slug;

        $user = H::userOrAdmin();
        event(new ProductViewedEvent($user, $product));

        $product->load([
            'media',
            "seo",
            "variations" => function ($query) {
                /** @var \Illuminate\Database\Eloquent\Relations\HasMany|\Domain\Products\QueryBuilders\ProductQueryBuilder $query */
                return $query->active();
            },
            "variations.parent",
            'variations.media',
            "brand",
            "accessory.category.parentCategory.parentCategory.parentCategory",
            'accessory.media',
            "similar.category.parentCategory.parentCategory.parentCategory",
            'similar.media',
            "related.category.parentCategory.parentCategory.parentCategory",
            'related.media',
            "works.category.parentCategory.parentCategory.parentCategory",
            'works.media',
            "charCategories.chars",
        ]);

        $breadcrumbs = Breadcrumbs::parquetWorksProductRoute($product);
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
