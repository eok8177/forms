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

use App\ApiCall;

class OutreachservicesController extends Controller
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
        $user = Auth::user();
        $api = new ApiCall;
        return view('user.outreachservices', [
            'organisations' => $api->getOrganisations($user),
            'healthCategories' => $api->getHealthCategories($user),
            'outreachServices' => $api->getOutreachServices($user)
        ]);
    }

}
