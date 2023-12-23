<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Resources\Web\Ajax\CartProductResource;
use Domain\Products\Models\Product\Product;
use Support\H;

class ProfileController extends BaseApiController
{
    public function __invoke()
    {
        $user = H::userOrAdminApi();

        $user->loadCount(["viewed", "serviceViewed"]);
        $user->load(["aside:id"]);

        $asideIds = $user->aside->pluck("id")->toArray();

        $cartItems = CartProductResource::collection($user->cart);

        $cartCount = $user->cart_not_trashed->reduce(function (int $acc, Product $product) {
            return $acc + ($product->cart_product->count ?? 1);
        }, 0);
        $cartRoute = route("cart.show");

        return [
            'data' => [
                'viewedCount' => $user->viewed_count,
                'cartCount' => $cartCount,
                'asideCount' => count($asideIds),
                'asideIds' => $asideIds,
                'cartItems' => $cartItems,
                'cartRoute' => $cartRoute,
                'isAnonymous' => $user->is_anonymous2,
                'isAdmin' => $user->is_admin,
                'lang' => str_replace('_', '-', app()->getLocale()),
            ],
        ];
    }
}
