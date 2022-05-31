<?php

namespace App\Http\Controllers\Admin;

use Domain\Services\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = inertia();
        $inertia->setRootView('admin.layouts.inertia');

        return $inertia->render('Services/Index', [
            'services' => Service::query()->get(),
        ]);
    }
}
