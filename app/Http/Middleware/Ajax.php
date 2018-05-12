<?php

namespace App\Http\Middleware;

use Closure;

class Ajax {
    public function handle($request, Closure $next) {
        if(!$request->ajax()) return response('Forbidden request. Ajax request expected.', 403);
        if (!$request->has('action')) return response('Forbidden request. Action is required.', 403);
        return $next($request);
    }
}
