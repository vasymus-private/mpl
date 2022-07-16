<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class TestInertiaController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = inertia();
        $inertia->setRootView('admin.layouts.inertia');

        return $inertia->render('Test/Index', []);
    }
}
