<?php

namespace App\Http\Middleware;

use Closure;

class Web {
    public function handle($request, Closure $next) {
        return $next($request);
    }
}
