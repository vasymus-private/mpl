<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Web\BaseWebController;
use App\Http\Requests\Web\Ajax\AsideProductsDeleteRequest;
use App\Http\Requests\Web\Ajax\AsideProductsStoreRequest;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class AsideProductsController extends BaseWebController
{
    public function store(AsideProductsStoreRequest $request)
    {
        /** @var \App\Models\User\User $user */
        $user = Auth::user();
        $user->aside()->detach($request->id);
        $user->aside()->syncWithoutDetaching($request->id);

        //$user->load(["aside:id"]);

        return [
            "data" => [
                "count" => $user->aside->count(),
                //"ids" => $user->aside->pluck("id")->toArray(),
            ]
        ];
    }

    public function delete(AsideProductsDeleteRequest $request)
    {
        /** @var \App\Models\User\User $user */
        $user = Auth::user();
        $user->aside()->detach($request->id);

        //$user->load(["aside:id"]);

        return [
            "data" => [
                "count" => $user->aside->count(),
                //"ids" => $user->aside->pluck("id")->toArray(),
            ]
        ];
    }
}
