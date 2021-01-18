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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CartCheckoutController extends BaseWebController
{
    public function __invoke(CartCheckoutRequest $request)
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        $order = $this->createOrder($request, $authUser);

        if ($order === null) {
            return redirect()->route("cart.show")->with('cart-error', "Что-то пошло не так. Попробуйте, пожалуйста, ещё раз.");
        }

        /** @var User|null $emailUser */
        $emailUser = User::query()->where("email", $request->email)->first();

        if ($authUser->is_identified) {
            $email = $authUser->email;
            $password = null;
        } else if (!$emailUser) {
            $email = $request->email;
            $authUser->email = $request->email;
            $authUser->name = $request->name;
            $authUser->phone = $request->phone;
            $password = H::random_str(6);
            $authUser->password = Hash::make($password);
            $authUser->save();
        } else {
            $email = $request->email;
            $password = null;
        }

        Mail::send(
            new OrderShippedMail(
                $order,
                $authUser->id,
                $email,
                $password
            )
        );

        try {
            $authUser->cart()->detach();
        } catch (\Exception $ignored) {}

        return redirect()->route("cart.success", $order->id);
    }

    protected function createOrder(CartCheckoutRequest $request, User $user): ?Order
    {
        $priceRetailRub = $user->cart_not_trashed->sumCartRetailPriceRub();

        $productsPrepare = [];

        $user->cart_not_trashed->each(function(Product $product) use(&$productsPrepare) {
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
                "user_id" => $user->id,
                "price_retail_rub" => $priceRetailRub,
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

            foreach (($request->attachment ?? []) as $file) {
                $order->addMedia($file)->toMediaCollection(Order::MC_INITIAL_ATTACHMENT);
            }
        } catch (\Exception $exception) {
            $order = null;
            DB::rollBack();
        }
        DB::commit();

        return $order;
    }
}
