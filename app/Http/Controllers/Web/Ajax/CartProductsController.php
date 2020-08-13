<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Web\BaseWebController;
use App\Http\Requests\Web\Ajax\CartProductsDeleteRequest;
use App\Http\Requests\Web\Ajax\CartProductsStoreRequest;
use App\Http\Requests\Web\Ajax\CartProductsUpdateRequest;
use App\Http\Resources\Web\Ajax\CartProductResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartProductsController extends BaseWebController
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $user->load([
            "cart" => function(BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }

    public function store(CartProductsStoreRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $user->cart()->detach($request->id);
        $user->cart()->syncWithoutDetaching([
            $request->id => ["count" => $request->count]
        ]);

        $user->load([
            "cart" => function(BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }

    public function update(CartProductsUpdateRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $product = $request->getProduct();
        $user->cart()->syncWithoutDetaching([
            $product->id => ["count" => $request->count],
        ]);

        $user->load([
            "cart" => function(BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }

    public function delete(CartProductsDeleteRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->cart()->detach($request->id);

        $user->load([
            "cart" => function(BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }
}
