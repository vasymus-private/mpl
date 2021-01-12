<?php

namespace App\View\Composers;

use App\Http\Resources\Web\Ajax\CartProductResource;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) return;

        $user->loadCount(["viewed", "serviceViewed"]);
        $user->load(["aside:id"]);

        $asideIds = $user->aside->pluck("id")->toArray();

        $cartIds = $user->cart->pluck("id")->toArray();

        $cartItems = CartProductResource::collection($user->cart);

        $cartCount = $user->cart->filter(function(Product $product) {
            return ($product->pivot->deleted_at ?? null) === null;
        })->reduce(function(int $acc, Product $product) {
            return $acc += ($product->pivot->count ?? 1);
        }, 0);

        $view->with("viewedCount", $user->viewed_count + $user->service_viewed_count)
            ->with("cartCount", $cartCount)
            ->with("asideCount", count($asideIds))
            ->with("asideIds", $asideIds)
            ->with("cartIds", $cartIds)
            ->with("cartItems", $cartItems)
        ;
    }
}
