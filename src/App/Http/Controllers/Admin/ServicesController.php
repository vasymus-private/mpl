<?php

namespace App\Http\Controllers\Admin;

use Domain\Services\Models\Service;
use Illuminate\Http\Request;
use Support\H;

class ServicesController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Services/Index', [
            'services' => Service::query()->get(),
        ]);
    }
}
