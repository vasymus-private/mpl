<?php

namespace App\Http\Controllers\Web;

use Domain\Orders\Models\Order;
use Domain\Orders\Models\PaymentMethod;
use Domain\Users\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var \Domain\Users\Models\User\User $user */
        $user = Auth::user();

        $user->load([
            "cart" => function(BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        $cartProducts = $user->cart;

        return view('web.pages.cart.cart', compact("cartProducts"));
    }

    public function success(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $order = Order::query()->where("user_id", $user->id)->findOrFail($request->order_id);
        $paymentMethods = PaymentMethod::query()->get();

        return view("web.pages.profile.profile-success", compact("order", "paymentMethods"));
    }
}
