<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CategoriesBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\CategoriesBulkUpdateRequest;
use App\Http\Resources\Admin\CategoryItemResource;
use Domain\Products\Actions\DeleteCategoryAction;
use Domain\Products\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoriesBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CategoriesBulkUpdateRequest $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CategoriesBulkUpdateRequest $request)
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

    /**
     * @param \App\Http\Requests\Admin\Ajax\CategoriesBulkDeleteRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(CategoriesBulkDeleteRequest $request)
    {
        $request->getCategories()->each(function (Category $category) {
            DeleteCategoryAction::cached()->execute($category);
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}
