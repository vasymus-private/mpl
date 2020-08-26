<?php

namespace App\Http\Controllers\Admin;

class HomeController extends BaseAdminController
{
    public function index()
    {
        dd("hi");
        return view("admin.pages.home.home");
    }
}
