<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view('admin.pages.categories.categories');
    }

    public function create()
    {

    }

    public function edit()
    {

    }
}
