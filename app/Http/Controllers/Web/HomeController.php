<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        /** @var Service|null $service */
        $service = $request->service_slug;

        if ($service) {
            return view("web.pages.services.{$service->slug}");
        } else {
            return view('web.pages.home.home');
        }
    }

    public function howto(Request $request)
    {
        return view("web.pages.home.howto");
    }

    public function delivery(Request $request)
    {
        return view("web.pages.home.delivery");
    }

    public function purchaseReturn(Request $request)
    {
        return view("web.pages.home.return");
    }

    public function contacts(Request $request)
    {
        return view("web.pages.home.contacts");
    }

    public function ask(Request $request)
    {
        return view("web.pages.home.ask");
    }

    public function viewed(Request $request)
    {
        return view('web.pages.home.viewed');
    }

    public function deferred(Request $request)
    {
        return view('web.pages.home.deferred');
    }
}
