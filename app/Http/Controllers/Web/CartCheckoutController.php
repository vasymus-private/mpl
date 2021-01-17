<?php

namespace App\Http\Controllers\Web;

use App\H;
use App\Http\Requests\Web\CartCheckoutRequest;
use App\Mail\OrderShippedMail;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderImportance;
use App\Models\OrderStatus;
use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartCheckoutController extends BaseWebController
{
    public function __invoke(CartCheckoutRequest $request) // TODO use db transaction
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        /** @var User|null $emailUser */
        $emailUser = User::query()->where("email", $request->email)->first();

        $priceRetail = $authUser->cart_not_trashed->sumCartRetailPriceRub();

        $productsPrepare = [];

        $authUser->cart_not_trashed->each(function(Product $product) use(&$productsPrepare) {
            $productsPrepare[$product->id] = [
                "count" => $product->cart_product->count ?? 1,
                "price_purchase" => $product->price_purchase,
                "price_purchase_currency_id" => $product->price_purchase_currency_id,
                "price_retail" => $product->price_retail,
                "price_retail_currency_id" => $product->price_retail_currency_id,
            ];
        });

        DB::beginTransaction();
        $order = null;
        try {
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

            $order->products()->attach($productsPrepare);

            foreach ($request->attachment as $file) {
                $order->addMedia($file)->toMediaCollection(Order::MC_INITIAL_ATTACHMENT);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        DB::commit();

        try {
            $authUser->cart()->detach();
        } catch (\Exception $ignored) {}

        if ($order === null) {
            return redirect()->route("cart.show")->with('order_error', "Что-то пошло не так. Попробуйте, пожалуйста, ещё раз.");
        }

        $shouldGeneratePassword = $emailUser === null || empty($emailUser->password ?? null);
        $password = $shouldGeneratePassword ? H::random_str(6) : null;

        Mail::send(
            new OrderShippedMail(
                $order,
                $authUser->id,
                $request->email,
                $password
            )
        );

        return redirect()->route("cart.success", $order->id);
    }
}
