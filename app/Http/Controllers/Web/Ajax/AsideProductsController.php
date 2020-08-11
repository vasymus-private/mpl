<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Web\BaseWebController;
use App\Http\Requests\Web\Ajax\AsideProductsStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AsideProductsController extends BaseWebController
{
    public function store(AsideProductsStoreRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->viewed()->syncWithoutDetaching($request->ids);

        $user->loadCount(["aside"]);

        return $user->aside_count;
    }
}
