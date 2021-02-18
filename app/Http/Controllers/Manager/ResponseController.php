<?php

/**
* Description:
* Controller (based on MVC architecture) for responses made by user
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index(Request $request) | Show list of responses made by user
* - response(Application $application) | Show response details
* - status(Request $request, Application $application) | Set status of the response to "rejected" (-1) or "accepted" (1)
*/

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\ApiLog;
use App\Application;
use App\ApplicationApproval;
use App\Entry;
use App\Form;
use App\Setting;

class ResponseController extends Controller
{
    /**
    * Description:
    * Show list of responses made by user
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/responses
    */
    public function index(Request $request)
    {
        list($apps, $filter) = Application::search($request);

        return view('manager.responses', [
            'apps' => $apps->get(),
            'select_forms' => $filter['selectAppsList'],
            'form_id' => $filter['form_id'],
            'status' => $filter['status'],
            'user' => $filter['user'],
            'from' => $filter['from'],
            'to' => $filter['to'],
            'search' => $filter['search']
        ]);
    }


    /**
    * Description:
    * Show response details
    *
    * List of parameters:
    * - $application : Application
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/manager/response/1080
    */
    public function response(Application $application)
    {
        return view('manager.response', [
            'app' => $application,
            'settings' => Setting::pluck('value', 'key')
        ]);
    }


    /**
    * Description:
    * Set status of the response to "rejected" (-1) or "accepted" (1)
    *
    * List of parameters:
    * - $request : Request
	* - $application : Application
    *
    * Return:
    * view content - list of responses, see index()
    *
    * Examples of usage:
    * - This feature is avaiable only for responses required to be approved by manager.
    * This can be replicated by the following steps:
    * Login as a manager. Select such response from the list of responses <baseUrl>/manager/responses
    * It should appear a button at the top-right corner "action", by clicking where
    * you should see a popup window with empty textarea and two buttons: Accept, Reject
    * By clicking any of these two buttons status() method is triggered
    */
    public function status(Request $request, Application $application)
    {
        $status = $request->input('status', 0);

        $appApprov = new ApplicationApproval;

        $application->status = ApplicationApproval::STATUS[$status];
        $application->save();

        $appApprov->application_id = $application->id;
        $appApprov->notes = $request->input('notes', NULL);
        $appApprov->status = $status;
        $appApprov->save();

        ApiLog::saveLog([
            'method' => 'Manager set status',
            'user_id' => $application->user_id,
            'form_id' => $application->form_id,
            'application_id' => $application->id,
            'response' => [
                'status' => $application->status,
                'notes' => $appApprov->notes
            ]
        ]);

		$application->createEntry();
        if ($application->status == 'accepted') {
            $application->managerSubmitEmail();
            $application->userAcceptEmail();
        } elseif ($application->status == 'rejected') {
            $application->userRejectEmail();
        }

        return redirect()->route('manager.responses');
    }
}
