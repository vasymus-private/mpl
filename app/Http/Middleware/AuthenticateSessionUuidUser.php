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
        $uuid = $request->cookie("session_uuid");

        if ($uuid === null) throw new NoSessionUuidException();

        $user = User::firstOrCreateBySessionUuid($uuid);
        Auth::guard()->login($user, true);

        return $next($request);
    }
}
