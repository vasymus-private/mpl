<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\BrandItemResource;
use App\Http\Resources\Admin\BrandResource;
use Domain\Products\Models\Brand;
use Illuminate\Http\Request;
use Support\H;

class BrandsController extends BaseAdminController
{
    public function index(Request $request)
    {
        $query = Brand::query()->select(['*']);

        if ($request->search) {
            $query->where(Brand::TABLE . ".name", "like", "%{$request->search}%");
        }

        $brands = $query->paginate($request->per_page ?? 20);
        $brands->appends($request->query());

        return view('admin.pages.brands.brands', compact('brands'));
    }

    public function indexTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = Brand::query()->select(["*"]);

        if ($request->search) {
            $query->where(sprintf('%s.name', Brand::TABLE), "LIKE", "%{$request->search}%");
        }

        return $inertia->render('Brands/Index', [
            'brands' => BrandItemResource::collection($query->paginate($request->per_page)),
        ]);
    }

    public function create(Request $request)
    {
        $brand = new Brand();

        return view('admin.pages.brands.brand', compact('brand'));
    }

    public function createTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Brands/CreateEdit');
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Products\Models\Brand $brand */
        $brand = $request->admin_brand;

        $brand->load('media');

        return view('admin.pages.brands.brand', compact('brand'));
    }

    public function editTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

        /** @var \Domain\Products\Models\Brand $brand */
        $brand = $request->admin_brand;

        return $inertia->render('Brands/CreateEdit', [
            'brand' => (new BrandResource($brand))->toArray($request),
        ]);
    }
}
