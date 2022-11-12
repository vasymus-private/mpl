<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Support\H;

class TestInertiaController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Test/Index', []);
    }
}
