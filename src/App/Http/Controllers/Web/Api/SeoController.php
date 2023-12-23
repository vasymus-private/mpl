<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Resources\Web\Api\SeoResource;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends BaseApiController
{
    public function show(Request $request)
    {
        switch ($request->type) {
            case Seo::TYPE_CATEGORY: {
                /** @var \Domain\Products\Models\Category|null $category */
                $category = Category::query()
                    ->select(['id'])
                    ->active()
                    ->with('seo')
                    ->where('slug', $request->slug)
                    ->first();

                return [
                    'data' => [
                        'app' => new SeoResource($this->getDefaultSeo()),
                        'entity' => $category?->seo?->is_not_empty ? new SeoResource($category->seo) : null,
                    ],
                ];
            }
            case Seo::TYPE_PRODUCT: {
                /** @var \Domain\Products\Models\Product\Product|null $product */
                $product = Product::query()
                    ->select(['id'])
                    ->active()
                    ->notVariations()
                    ->where('slug', $request->slug)
                    ->with('seo')
                    ->first();

                return [
                    'data' => [
                        'app' => new SeoResource($this->getDefaultSeo()),
                        'entity' => $product?->seo?->is_not_empty ? new SeoResource($product->seo) : null,
                    ],
                ];
            }
            case Seo::TYPE_APP:
            default: {
                return [
                    'data' => [
                        'app' => new SeoResource($this->getDefaultSeo()),
                        'entity' => null,
                    ],
                ];
            }
        }
    }

    protected function getDefaultSeo(): Seo
    {
        return Seo::appSeo();
    }
}
