<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Resources\Admin\ProductSearchResource;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductSearchController extends BaseAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function index(Request $request, GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction)
    {
        $productQuery = Product::query()->notVariations();

        if ($request->category_id) {
            $categoryAndSubtreeIds = $getCategoryAndSubtreeIdsAction->execute($request->category_id);

            $productQuery->forMainAndRelatedCategories($categoryAndSubtreeIds);
        }

        if ($request->search) {
            $productQuery->where(Product::TABLE . ".name", "like", "%{$request->search}%");
        }

        return ProductSearchResource::collection(
            $productQuery->paginate(
                $request->input('per_page', 20)
            )
        );
    }
}
