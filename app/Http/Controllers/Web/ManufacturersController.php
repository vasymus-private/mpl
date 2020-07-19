<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;

class ManufacturersController extends BaseWebController
{
    public function index(Request $request)
    {
        $categories = Category::parents()->with("subcategories.subcategories.subcategories")->get();

        return view("web.manufacturers", compact("categories"));
    }
}
