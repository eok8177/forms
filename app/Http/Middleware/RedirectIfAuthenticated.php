<?php
 
/**
* Description:
* Middleware intended to redirect a user to their default authenticated page
* 
* List of methods:
* - handle($request, Closure $next, $guard = null) | Handle an incoming request
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
    * Description
    * Handle an incoming request
    *
    * List of parameters:
    * - $request : \Illuminate\Http\Request
    * - $next : Closure
    * - $guard : string|null
    *
    * Return:
    * mixed
    */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->intended('/');
        }

        return $next($request);
    }
}
