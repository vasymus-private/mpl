<?php

namespace App\Http\Controllers\Web;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandsController extends BaseWebController
{
    public function index(Request $request)
    {
        $brandsList = Brand::query()->paginate();

        return view("web.pages.brands.brands", compact("brandsList"));
    }

    public function show(Request $request)
    {

    }
}
