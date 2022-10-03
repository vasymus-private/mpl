<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Resources\Admin\Ajax\ProductSearchResource;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductSearchController extends BaseAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Domain\Products\Actions\GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function index(Request $request, GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction)
    {
        $validated = $request->validate([
            'category_ids' => 'array|nullable',
            'category_ids.*' => 'integer',
            'search' => 'string|nullable',
            'brand_id' => 'integer|nullable',
        ]);
        $productQuery = Product::query()->notVariations()->with('variations.media', 'media');

        if (! empty($validated['category_ids'])) {
            $categoriesAndSubtreeIds = $getCategoryAndSubtreeIdsAction->execute($validated['category_ids']);

            $productQuery->forMainAndRelatedCategories($categoriesAndSubtreeIds);
        }

        if (! empty($validated['search'])) {
            $productQuery->where(
                sprintf('%s.name', Product::TABLE),
                'like',
                sprintf('%%%s%%', $validated['search'])
            );
        }

        if (! empty($validated['brand_id'])) {
            $productQuery->whereBrandId($validated['brand_id']);
        }

        return ProductSearchResource::collection(
            $productQuery->paginate(
                $request->input('per_page', 20)
            )
        );
    }
}
