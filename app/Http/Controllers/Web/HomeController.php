<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $categories = Category::parents()->with("subcategories.subcategories.subcategories")->get();

        /** @var Service|null $service */
        $service = $request->service_slug;

        $data = compact("categories");

        if ($service) {
            return view("web.services.{$service->slug}", $data);
        } else {
            return view('web.home', $data);
        }
    }
}
