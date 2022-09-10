<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CategoriesBulkRequest;
use App\Http\Resources\Admin\CategoryItemResource;
use Domain\Products\Models\Category;

class CategoriesBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CategoriesBulkRequest $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CategoriesBulkRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $categoriesToUpdate = Category::query()
            ->whereIn('id', $ids)
            ->get();

        $categoriesToUpdate->each(function (Category $product) use ($payload) {
            $toUpdate = $payload[$product->id];
            $product->forceFill(
                collect($toUpdate->all())
                    ->except('id')
                    ->all()
            );
            $product->save();
        });

        return CategoryItemResource::collection(
            Category::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }
}
