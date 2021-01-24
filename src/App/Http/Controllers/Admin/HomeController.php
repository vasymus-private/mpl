<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends BaseAdminController
{
    public function index(Request $request)
    {
        dump($request->user());
        return view("admin.pages.home.home");
    }
}
