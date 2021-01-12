<?php

namespace App\Http\Middleware;

use App\Services\Common\Common;
use Closure;
use Illuminate\Support\Facades\Log;

class AnonymousUid
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
        $uid = $request->cookie("anonymous_uid");
        $cookie = cookie();
        if ($uid === null) {
            $cookie->queue(
                $cookie->forever(
                    "anonymous_uid",
                    $uid = Common::uuid(),
                    null,
                    null,
                    null,
                    false
                )
            );
            $request->cookies->add(["anonymous_uid" => $uid]);
        }

        return $next($request);
    }
}
