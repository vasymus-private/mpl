<?php

namespace App\Http\Middleware;

use Domain\Users\Models\User\User;
use Illuminate\Support\Facades\Auth;

class AuthenticateAll
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $user = Auth::user();
        if ($user === null) {
            $user = User::createAnonymous();
            Auth::guard()->login($user, true);
        }

        return $next($request);
    }
}
