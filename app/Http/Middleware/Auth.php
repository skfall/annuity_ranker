<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class Auth {
    public function handle($request, Closure $next) {
        return $next($request);
    }
}
