<?php

namespace App\View\Composers;

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

        $user->loadCount(["viewed"]);
        $user->load(["aside:id"]);

        $asideIds = $user->aside->pluck("id")->toArray();

        $cartIds = $user->cart->pluck("id")->toArray();

        $cartCount = $user->cart->reduce(function(int $acc, Product $product) {
            return $acc += ($product->pivot->count ?? 1);
        }, 0);

        $view->with("viewedCount", $user->viewed_count)
            ->with("cartCount", $cartCount)
            ->with("asideCount", count($asideIds))
            ->with("asideIds", $asideIds)
            ->with("cartIds", $cartIds)
        ;
    }
}
