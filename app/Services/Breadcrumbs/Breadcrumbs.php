<?php

namespace App\Services\Breadcrumbs;

use App\Models\Category;
use App\Models\Product\Product;

class Breadcrumbs
{
    /**
     * @param Category|null $category
     * @param Category|null $subcategory1
     * @param Category|null $subcategory2
     * @param Category|null $subcategory3
     *
     * @return BreadcrumbDTO[]
     */
    public static function productsRoute(Category $category = null, Category $subcategory1 = null, Category $subcategory2 = null, Category $subcategory3 = null): array
    {
        $breadcrumbs = [];

        if ($category) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $category->name,
                "url" => route("products.index", [$category->slug]),
            ]);
        }
        if ($subcategory1) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory1->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug]),
            ]);
        }
        if ($subcategory2) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory2->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug]),
            ]);
        }
        if ($subcategory3) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory3->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug, $subcategory3->slug]),
            ]);
        }

        return $breadcrumbs;
    }

    /**
     * @param Product $product
     * @param Category $category
     * @param Category|null $subcategory1
     * @param Category|null $subcategory2
     * @param Category|null $subcategory3
     *
     * @return BreadcrumbDTO[]
     */
    public static function productRoute(Product $product, Category $category, Category $subcategory1 = null, Category $subcategory2 = null, Category $subcategory3 = null): array
    {
        $breadcrumbs = [
            new BreadcrumbDTO([
                "name" => $category->name,
                "url" => route("products.index", [$category->slug]),
            ]),
        ];
        if ($subcategory1) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory1->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug]),
            ]);
        }
        if ($subcategory2) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory2->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug]),
            ]);
        }
        if ($subcategory3) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory3->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug, $subcategory3->slug]),
            ]);
        }

        return $breadcrumbs;
    }
}
