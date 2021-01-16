<?php

namespace App\Http\Middleware;

use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class RedirectIfIdentified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        /** @var User|null $user */
        $user = Auth::guard($guard)->user();
        if ($user && $user->is_identified) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
