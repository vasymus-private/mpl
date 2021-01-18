<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use App\Models\User\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseWebController
{
    public function identify(Request $request)
    {
        $id = $request->route('id');
        $email = $request->route("email");
        $hash = $request->route("hash");

        /** @var User $user */
        $user = Auth::user();
        if (!$user)
            return redirect()->route('home');

        /** @var User $emailUser */
        $emailUser = User::query()->where("email", $email)->firstOrFail();

        if (
            ! hash_equals((string) $id, (string) $user->getKey()) &&
            ! hash_equals((string) $id, (string) $emailUser->getKey())
        ) {
            throw new AuthorizationException;
        }

        if (
            ! hash_equals((string) $hash, sha1($user->email)) &&
            ! hash_equals((string) $hash, sha1($emailUser->email))
        ) {
            throw new AuthorizationException;
        }

        if ($user->id === $emailUser->id) {
            return redirect()->route("profile");
        }

        User::handleTransferProducts($user, $emailUser);
        User::handleTransferOrders($user, $emailUser);

        Auth::logout();
        Auth::login($emailUser);

        return redirect()->route("profile");
    }

    public function show(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        /** @see Order::products() */
        $orders = $user->orders()->with(["products.parent.category.parentCategory", "products.category.parentCategory.parentCategory", "products.media"])->paginate($request->input("per_page"));

        return view("web.pages.profile.profile", compact("orders"));
    }
}
