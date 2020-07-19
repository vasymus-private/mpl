<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::parents()->with("subcategories.subcategories.subcategories")->get();
        $manufacturers = Manufacturer::query()->with("products:id")->get();

        return view('web.home', compact("categories", "manufacturers"));
    }
}
