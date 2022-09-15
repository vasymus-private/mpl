<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateBrandRequest;
use App\Http\Resources\Admin\BrandResource;
use Domain\Products\Actions\CreateOrUpdateBrand\CreateOrUpdateBrandAction;

class BrandsController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateBrandRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateBrand\CreateOrUpdateBrandAction $createOrUpdateBrandAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateUpdateBrandRequest $request, CreateOrUpdateBrandAction $createOrUpdateBrandAction)
    {
        $brand = $createOrUpdateBrandAction->execute($request->prepare());

        return new BrandResource($brand);
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateBrandRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateBrand\CreateOrUpdateBrandAction $createOrUpdateBrandAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CreateUpdateBrandRequest $request, CreateOrUpdateBrandAction $createOrUpdateBrandAction)
    {
        /** @var \Domain\Products\Models\Brand $target */
        $target = $request->admin_brand;

        $brand = $createOrUpdateBrandAction->execute($request->prepare(), $target);

        return new BrandResource($brand);
    }
}
