<?php

namespace App\Http\Middleware;

use Domain\Users\Models\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotIdentified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        /** @var User|null $user */
        $user = Auth::guard($guard)->user();

        if (!$user || $user->is_anonymous2) {
            return redirect(RouteServiceProvider::LOGIN);
        }

        return $next($request);
    }
}
