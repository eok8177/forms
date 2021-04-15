<?php

/**
* Description:
* 
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\ApiLog;
use App\Application;
use App\ApplicationApproval;
use App\Form;
use App\Setting;

class GrantController extends Controller
{
    /**
    * Description:
    * 
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * 
    */
    public function index(Request $request)
    {
        return view('user.grants');
    }

}
