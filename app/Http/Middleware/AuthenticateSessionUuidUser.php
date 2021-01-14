<?php

namespace App\Http\Middleware;

use App\Exceptions\NoSessionUuidException;
use App\Models\User\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticateSessionUuidUser
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
        /** @var User $user */
        if ($user = $request->user()) {
            return $next($request);
        }

        $uid = $request->cookie("session_uuid");

        if ($uid === null) throw new NoSessionUuidException();

        $user = User::firstOrCreateViaSessionUuid($uid);
        Auth::guard()->login($user, true);

        return $next($request);
    }
}
