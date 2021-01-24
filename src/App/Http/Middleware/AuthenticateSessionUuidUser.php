<?php

namespace App\Http\Middleware;

use App\Exceptions\SessionUuidNotProvidedException;
use Domain\Users\Models\User\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

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
//        $uuid = $request->cookie("session_uuid");
//
//        if (empty($uuid)) throw new SessionUuidNotProvidedException();
//
//        $user = User::firstOrCreateBySessionUuid(Uuid::fromString($uuid));
//        Auth::guard()->login($user, true);

        return $next($request);
    }
}
