<?php

namespace App\Http\Controllers\Web;

use App\Models\Service;
use App\Services\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;

class ServicesController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var Service|null $service */
        $service = $request->service_slug;

        $breadcrumbs = Breadcrumbs::serviceRoute($service);

        return view("web.pages.services.{$service->slug}", compact("breadcrumbs"));
    }
}
