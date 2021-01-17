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

        $priceRetail = $authUser->cart_not_trashed->sumCartRetailPriceRub();

        $order = Order::forceCreate([
            "user_id" => $authUser->id,
            "price_retail" => $priceRetail,
            "order_status_id" => OrderStatus::ID_OPEN,
            "importance_id" => OrderImportance::ID_GREY,
            "comment_user" => $request->comment,
            "request" => [
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
            ]
        ]);


        $productsPrepare = [];

        $authUser->cart_not_trashed->each(function(Product $product) use(&$productsPrepare) {
            $productsPrepare[$product->id] = [
                "count" => $product->cart_product->count ?? 1,
                "price_purchase" => $product->price_purchase,
                "price_retail" => $product->price_retail,
            ];
        });

        $order->products()->attach($productsPrepare);


    }
}
