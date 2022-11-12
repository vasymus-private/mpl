<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\BrandsBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\BrandsBulkUpdateRequest;
use App\Http\Resources\Admin\BrandItemResource;
use Domain\Products\Actions\DeleteBrandAction;
use Domain\Products\Models\Brand;
use Symfony\Component\HttpFoundation\Response;

class BrandsBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\BrandsBulkUpdateRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(BrandsBulkUpdateRequest $request)
    {
        $payload = $request->payload();
        $ids = collect($payload)->pluck('id')->toArray();

        $categoriesToUpdate = Brand::query()
            ->whereIn('id', $ids)
            ->get();

        $categoriesToUpdate->each(function (Brand $product) use ($payload) {
            $toUpdate = $payload[$product->id];
            $product->forceFill(
                collect($toUpdate->all())
                    ->except(['id'])
                    ->all()
            );
            $product->save();
        });

        return BrandItemResource::collection(
            Brand::query()
                ->whereIn('id', $ids)
                ->get()
        );
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\BrandsBulkDeleteRequest $request
     * @param \Domain\Products\Actions\DeleteBrandAction $deleteBrandAction
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(BrandsBulkDeleteRequest $request, DeleteBrandAction $deleteBrandAction)
    {
        $brands = Brand::query()->whereIn(sprintf('%s.id', Brand::TABLE), $request->ids)->get();

        $brands->each(function (Brand $brand) use ($deleteBrandAction) {
            $deleteBrandAction->execute($brand);
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}
