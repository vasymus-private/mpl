<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Domain\Users\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('web.pages.home.home');
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
        /** @var User $user */
        $user = Auth::user();

        $products = $user->viewed()->orderBy("pivot_created_at", "desc")->paginate(
            $request->input("per_page")
        );

        return view("web.pages.home.viewed", compact("products"));
    }

    public function aside(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $products = $user->aside()->orderBy("pivot_created_at", "desc")->get();

        return view('web.pages.home.aside', compact("products"));
    }
}
