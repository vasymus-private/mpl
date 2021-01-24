<?php

namespace App\Http\Controllers\Web;

use Domain\Services\Events\ServiceViewedEvent;
use Domain\Services\Models\Service;
use Support\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var Service|null $service */
        $service = $request->service_slug;

        event(new ServiceViewedEvent(Auth::user(), $service));

        $breadcrumbs = Breadcrumbs::serviceRoute($service);

        return view("web.pages.services.{$service->slug}", compact("breadcrumbs"));
    }
}
