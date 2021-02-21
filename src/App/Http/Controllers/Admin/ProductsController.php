<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Actions\FiltrateByCategoriesAction;
use Domain\Products\DTOs\FiltrateByCategoriesParamsDTO;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductsController extends BaseAdminController
{
    public function index(Request $request, FiltrateByCategoriesAction $filtrate)
    {
        $query = Product::query()->notVariations();

        $filtrateParams = new FiltrateByCategoriesParamsDTO();

        if ($request->has('category_id')) {
            $filtrateParams->category = Category::query()->findOrFail($request->category_id);
        }
        if ($request->has('subcategory1_id')) {
            $filtrateParams->subcategory1 = Category::query()->findOrFail($request->subcategory1_id);
        }
        if ($request->has('subcategory2_id')) {
            $filtrateParams->subcategory2 = Category::query()->findOrFail($request->subcategory2_id);
        }
        if ($request->has('subcategory3_id')) {
            $filtrateParams->subcategory3 = Category::query()->findOrFail($request->subcategory3_id);
        }

        $query = $filtrate->execute($query, $filtrateParams);

    }
}
