<?php

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

    public function response(Application $application)
    {
        return view('manager.response', [
            'app' => $application,
            'settings' => Setting::pluck('value', 'key')
        ]);
    }

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
