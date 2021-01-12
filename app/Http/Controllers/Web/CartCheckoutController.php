<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\CartCheckoutRequest;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderImportance;
use App\Models\OrderStatus;
use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartCheckoutController extends BaseWebController
{
    /**
     * @param CartCheckoutRequest|Request $request
     * */
    public function __invoke(CartCheckoutRequest $request) // TODO use db transaction
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        /** @var User $emailUser */
        $emailUser = User::query()->where("email", $request->email)->first();

        if ($emailUser !== null) {
            User::handleTranser($authUser, $emailUser);
            $user = $emailUser;
        } else {
            $user = $authUser;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        $order = new Order();

        $order->user_id = $user->id;

        $priceRetail = $user->cart->reduce(function(float $acc, Product $product) {
            return $acc += $product->price_retail;
        }, 0.0);

        $order->price_retail = $priceRetail;
        $order->order_status_id = OrderStatus::ID_OPEN;
        $order->importance_id = OrderImportance::ID_GREY;
        $order->comment_user = $request->comment;
        $order->save();

        $productsPrepare = [];

        $user->cart->each(function(Product $product) use(&$productsPrepare) {
            $productsPrepare[$product->id] = [
                "count" => $product->pivot->count ?? 1,
                "price_purchase" => $product->price_purchase,
                "price_retail" => $product->price_retail,
            ];
        });

        $order->products()->attach($productsPrepare);


    }
}
