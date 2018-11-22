<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {

        if (!$request->secure() ) {
                return redirect()->secure($request->getRequestUri()); //move into production
        }

        return $next($request);

    }
}
