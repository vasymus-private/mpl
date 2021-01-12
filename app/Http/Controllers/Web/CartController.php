<?php

namespace App\Http\Controllers\Web;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var \App\Models\User\User $user */
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
}
