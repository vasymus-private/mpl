<?php

namespace App\Http\Controllers\Web;

use Domain\Users\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersConstroller extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $order = $user->orders()->findOrFail($request->id);

        return view("web.pages.orders.order", compact("order"));
    }
}
