<?php

namespace App\Http\Middleware;

use App\Services\Common\Common;
use Closure;
use Illuminate\Support\Facades\Log;

class SessionUuid
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
        $uid = $request->cookie("session_uuid");
        $cookie = cookie();
        if ($uid === null) {
            $cookie->queue(
                $cookie->forever(
                    "session_uuid",
                    $uid = Common::uuid(),
                    null,
                    null,
                    null,
                    false
                )
            );
            $request->cookies->add(["session_uuid" => $uid]);
        }

        return $next($request);
    }
}
