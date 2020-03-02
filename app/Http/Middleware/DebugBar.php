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
            $request->session()->put('debugbar', 'on');
        }
        if ($request->get("debugbar") == 'off') {
            $request->session()->forget('debugbar');
        }

        if ($request->session()->has('debugbar')) {
            \Debugbar::enable();
        } else {
            \Debugbar::disable();
        }
        return $next($request);
    }
}
