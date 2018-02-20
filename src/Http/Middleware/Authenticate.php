<?php

namespace KABBOUCHI\LogViewer\Http\Middleware;

use KABBOUCHI\LogViewer\LogViewer;

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
        return LogViewer::check($request) ? $next($request) : abort(403);
    }
}