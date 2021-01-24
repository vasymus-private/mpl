<?php

namespace App\Http\Middleware;

use App\Services\Common\Common;
use Closure;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class ProvideSessionUuid
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
        $cookie = cookie();
        if ($uuid === null) {
            $cookie->queue(
                $cookie->forever(
                    "session_uuid",
                    $uuid = Uuid::uuid4()->toString(),
                    null,
                    null,
                    null,
                    false
                )
            );
            $request->cookies->add(["session_uuid" => $uuid]);
        }

        return $next($request);
    }
}
