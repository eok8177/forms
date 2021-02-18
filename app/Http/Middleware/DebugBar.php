<?php
 
/**
* Description:
* Debugbar middelware - show or hide an debug info panel at the bottom of the browser
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - handle($request, Closure $next) | Handle an incoming request
*/

namespace App\Http\Middleware;

use Closure;

class DebugBar
{
    /**
    * Description:
    * Handle an incoming request
    *
    * List of parameters:
    * - $request : Request
    * - $next : Closure
    * 
    * Return:
    * mixed
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
