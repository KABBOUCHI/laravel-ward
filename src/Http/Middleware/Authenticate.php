<?php

namespace KABBOUCHI\Ward\Http\Middleware;

use KABBOUCHI\Ward\Ward;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return \Illuminate\Http\Response|null
     */
    public function handle($request, $next)
    {
        return Ward::check($request) ? $next($request) : abort(403);
    }
}
