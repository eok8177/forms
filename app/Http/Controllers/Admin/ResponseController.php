<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Application;
use App\ApplicationApproval;
use App\Entry;
use App\Form;

class ResponseController extends Controller
{
    public function index(Request $request)
    {
        list($apps, $filter) = Application::search($request);

        return view('admin.response', [
            'entries' => $apps->get(),
            'select_forms' => Form::selectAppsList(),
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
        return view('admin.entry', ['app' => $app]);
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

        if ($app->status == 'accepted') {
            $app->createEntry();
            $app->adminSubmitEmail();
            $app->userAcceptEmail();
        } elseif ($app->status == 'rejected') {
            $app->userRejectEmail();
        }

        return redirect()->route('admin.responses');
    }

}
