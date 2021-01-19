<?php

namespace App\View\Composers;

use App\Http\Resources\Web\Ajax\CartProductResource;
use App\Models\Product\Product;
use App\Models\User\User;
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
        /** @var \App\Models\User\User $user */
        $user = Auth::user();

        if (!$user) return;

        $user->loadCount(["viewed", "serviceViewed"]);
        $user->load(["aside:id"]);

        $asideIds = $user->aside->pluck("id")->toArray();

        $cartItems = CartProductResource::collection($user->cart);

        $cartCount = $user->cart_not_trashed->reduce(function(int $acc, Product $product) {
            return $acc + ($product->cart_product->count ?? 1);
        }, 0);
        $cartRoute = route("cart.show");

        $view->with("viewedCount", $user->viewed_count + $user->service_viewed_count)
            ->with("cartCount", $cartCount)
            ->with("asideCount", count($asideIds))
            ->with("asideIds", $asideIds)
            ->with("cartItems", $cartItems)
            ->with("cartRoute", $cartRoute)
        ;
    }
}
