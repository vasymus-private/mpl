<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use Domain\Products\Actions\CreateOrUpdateCategory\CreateOrUpdateCategoryAction;

class CategoriesController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateCategoryRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateCategory\CreateOrUpdateCategoryAction $createOrUpdateCategoryAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function store(CreateUpdateCategoryRequest $request, CreateOrUpdateCategoryAction $createOrUpdateCategoryAction)
    {
        $category = $createOrUpdateCategoryAction->execute(
            $request->prepare()
        );

        $category->setRelations([]);

        return new CategoryResource($category);
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateCategoryRequest $request
     * @param \Domain\Products\Actions\CreateOrUpdateCategory\CreateOrUpdateCategoryAction $createOrUpdateCategoryAction
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function update(CreateUpdateCategoryRequest $request, CreateOrUpdateCategoryAction $createOrUpdateCategoryAction)
    {
        /** @var \Domain\Products\Models\Category $target */
        $target = $request->admin_category;

        $category = $createOrUpdateCategoryAction->execute(
            $request->prepare(),
            $target
        );

        $category->setRelations([]);

        return new CategoryResource($category);
    }
}
