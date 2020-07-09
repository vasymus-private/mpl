<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticateAnonymousUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()) return $next($request);

        $uid = $request->cookie("anonymous_uid");

        if ($uid === null) throw new \LogicException("No uid provided");

        $user = User::firstOrCreateAnonymous($uid);
        Auth::guard()->login($user, true);

        return $next($request);
    }
}
