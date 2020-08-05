<?php

namespace App\Http\Controllers\Web;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var Service|null $service */
        $service = $request->service_slug;

        return view("web.pages.services.{$service->slug}");
    }
}
