<?php
 
/**
* Description:
* Authenticate middleware
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - redirectTo($request) | Get the path the user should be redirected to when they are not authenticated
*/

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
    * Description:
    * Get the path the user should be redirected to when they are not authenticated
    *
    * List of parameters:
    * - $request : Request
    * 
    * Return:
    * string
    */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
