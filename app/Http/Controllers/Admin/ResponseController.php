<?php

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

    public function entry(Application $app)
    {
        return view('admin.entry', [
            'app' => $app,
            'settings' => Setting::pluck('value', 'key')
        ]);
    }

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

    public function sendEmail(Application $app)
    {
        echo "Run: ".date('i:s')."\n";
        //$app->userSubmitEmail();
        $app->userAcceptEmail();
        $app->adminSubmitEmail();
        $app->userRejectEmail();
        return $app->id;
    }

    public function destroy(Application $app)
    {
		$app->deleteEntry();
        $app->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

}
