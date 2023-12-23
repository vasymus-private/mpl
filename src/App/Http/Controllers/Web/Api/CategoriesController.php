<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Resources\Web\Api\CategoryResource;
use Domain\Products\Models\Category;

class CategoriesController extends BaseApiController
{
    public function __invoke()
    {
        return [
            'data' => [
                'parquetMaterials' => CategoryResource::collection(
                    Category::query()
                        ->parents()
                        ->active()
                        ->ordering()
                        ->parquetMaterials()
                        ->with("subcategories.subcategories.subcategories")
                        ->get()
                ),
                'parquetWorkCategories' => CategoryResource::collection(
                    Category::query()
                        ->parents()
                        ->active()
                        ->ordering()
                        ->parquetWorks()
                        ->get()
                ),
            ]
        ];
    }
}
