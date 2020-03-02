<?php

namespace App\Http\Middleware;

use Closure;

class DebugBar
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
        if ($request->get("debugbar") == 'on') {
            \Debugbar::enable();
        } else {
            \Debugbar::disable();
        }
        return $next($request);
    }
}
