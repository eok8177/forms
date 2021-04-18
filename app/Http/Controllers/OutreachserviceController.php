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

class OutreachserviceController extends Controller
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
        ]);
    }

    public function getOutreachServices(Request $request)
    {
        $filter = $request->get('filter', false);

        $user = Auth::user();
        $api = new ApiCall;
        $outreachServices = $api->getOutreachServices($user);

        $data = collect($outreachServices[0]);

        // Better solution: filtering this via API request
        if ($filter) {
            if ($filter['scheduleRef']) 
                $data = $data->where('ServiceRef',$filter['scheduleRef']);
        }

        return view('user.outreachservicestable', [
            'data' => $data,
            'pagination' => $outreachServices[1],
        ]);
    }


    public function getOutreachServiceVisits(Request $request)
    {
        $id = $request->get('ref', false);
        $filter = $request->get('filter', false);

        $api = new ApiCall;
        $outreachServices = $api->getOutreachServiceVisits($id);

        $data = collect($outreachServices[0]);

        // Better solution: filtering this via API request
        if ($filter) {
            if ($filter['visitStatus'] != -1) 
                $data = $data->where('VisitReportStatus',$filter['visitStatus']);
            if ($filter['methodOfDelivery'] != -1) 
                $data = $data->where('DeliveryMode',$filter['methodOfDelivery']);
            $data = $data->where('DateFrom','>=',$filter['visitDateFrom']);
            $data = $data->where('DateTo','<=',$filter['visitDateTo']);
        }

        return view('user.outreachservicetable', [
            'data' => $data,
            'pagination' => $outreachServices[1],
        ]);
    }

}
