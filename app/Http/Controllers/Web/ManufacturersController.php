<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class ManufacturersController extends BaseWebController
{
    public function index(Request $request)
    {
        return view("web.pages.manufacturers.manufacturers");
    }
}
