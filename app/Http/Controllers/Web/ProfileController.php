<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        /** @see Order::products() */
        $orders = $user->orders()->with(["products"])->paginate($request->input("per_page"));

        return view("web.pages.profile.profile", compact("orders"));
    }
}
