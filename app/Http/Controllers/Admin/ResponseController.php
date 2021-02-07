<?php

/**
* Description:
* Controller (based on MVC architecture) for responses viewed by admin
* 
* List of methods:
* - index(Request $request) | Show the list of responses
* - entry(Application $app) | View detailed response
* - status(Request $request, Application $app) | Set status of the response to "rejected" (-1) or "accepted" (1)
* - sendEmail(Application $app)
* - destroy(Application $app) | Delete response
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Application;
use App\ApplicationApproval;
use App\Entry;
use App\Form;
use App\Setting;

class ResponseController extends Controller
{

    /**
    * Description:
    * Show the list of responses
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - 
    */
    public function index(Request $request)
    {
        list($apps, $filter) = Application::search($request);

        return view('admin.response', [
            'entries' => $apps->get(),
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
    * View detailed response
    *
    * List of parameters:
    * - $app : Application
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/entry/1080
    */
    public function entry(Application $app)
    {
        return view('admin.entry', [
            'app' => $app,
            'settings' => Setting::pluck('value', 'key')
        ]);
    }


    /**
    * Description:
    * Set status of the response to "rejected" (-1) or "accepted" (1)
    * TOREVIEW -- PS: NOT to be avaible for admin
    *
    * List of parameters:
    * - $request : Request
    * - $app : Application
    *
    * Return:
    * view content - list of responses, see index()
    *
    * Examples of usage:
    * - 
    */
    public function status(Request $request, Application $app)
    {
        $status = $request->input('status', 0);

        $appApprov = new ApplicationApproval;

        $app->status = ApplicationApproval::STATUS[$status];
        $app->save();

        $appApprov->application_id = $app->id;
        $appApprov->notes = $request->input('notes', NULL);
        $appApprov->status = $status;
        $appApprov->save();

		$app->createEntry();
        if ($app->status == 'accepted') {
            $app->adminSubmitEmail();
            $app->userAcceptEmail();
        } elseif ($app->status == 'rejected') {
            $app->userRejectEmail();
        }

        return redirect()->route('admin.responses');
    }


    /**
    * Description:
    * 
    *
    * List of parameters:
    * - $app : Application
    *
    * Return:
    * 
    *
    * Examples of usage:
    * - 
    */
    public function sendEmail(Application $app)
    {
        echo "Run: ".date('i:s')."\n";
        //$app->userSubmitEmail();
        $app->userAcceptEmail();
        $app->adminSubmitEmail();
        $app->userRejectEmail();
        return $app->id;
    }


    /**
    * Description:
    * Delete response
    *
    * List of parameters:
    * - $app : Application
    *
    * Return:
    * Response: {status: 'success'}
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/responses and click to trash icon at any item in the list
    */
    public function destroy(Application $app)
    {
		$app->deleteEntry();
        $app->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

}
