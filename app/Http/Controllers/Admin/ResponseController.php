<?php

/**
* Description:
* Controller (based on MVC architecture) for responses viewed by admin
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index(Request $request) | Show the list of responses
* - entry(Application $app) | View detailed response
* - sendEmail(Application $app)
* - destroy(Application $app) | Delete response
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Application;
use App\ApplicationApproval;
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
    $mode = 'UAT'; $id=862;
    echo '<pre>'.$mode.'--'.$id.'<br>';
    $app1 = Application::find($id); 
    if ($app1) {
        $app1->checkFiles();die();
    }
    die('__');
        list($apps, $filter) = Application::search($request);

        // check all apps (responses) for attachments with zero file sizes
        foreach ($apps->get() as $app) {
            $app->checkFiles();
        }

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
