<?php
 
/**
* Description:
* Middleware to check against any role passed to it
* 
* List of methods:
* - handle($request, Closure $next) | Handle an incoming request
*/

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
    * Description:
    * Handle an incoming request
    *
    * List of parameters:
    * - $request : Request
    * - $next : Closure
    *
    * Return
    * mixed
    */
    public function handle($request, Closure $next)
    {
        if ($request->user() === null) {
            return redirect('/login');
        }
        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;

        if ($request->user()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }
        return redirect('/');
    }
}
