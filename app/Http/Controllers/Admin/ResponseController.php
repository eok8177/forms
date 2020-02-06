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
        $user = Auth::user();

        $form_id = $request->input('id', 0);
        $status = $request->input('status', Application::STATUS_SUBMITTED);

        $from = $request->input('from', false);
        $to = $request->input('to', false);

        $forms = Application::select('form_id')->distinct()->pluck('form_id')->toArray();

        $entries = Application::orderBy('created_at', 'desc')->where('status', '!=', 'deleted');

        if ($form_id > 0) {
            $entries->where('form_id', $form_id);
        }

        if ($status != Application::STATUS_ALL) {
            $entries->where('status', $status);
        }

        if ($from) {
            $entries->where('created_at', '>=', $from);
        }

        if ($to) {
            $entries->where('created_at', '<=', $to);
        }

        if ($user->role == 'manager') {
            $groupIds = $user->groups->pluck('id')->toArray();
            $forms = Form::whereHas('groups', function($q) use ($groupIds) {
                $q->whereIn('group_id', $groupIds);
            })->pluck('id')->toArray();
            $entries->whereIn('form_id', $forms);
        }

        $select_forms = [0 =>'All Forms'] + Form::whereIn('id',$forms)->pluck('title', 'id')->all();

        return view('admin.response', [
            'entries' => $entries->get(),
            'select_forms' => $select_forms,
            'form_id' => $form_id,
            'status' => $status,
            'user' => $user,
            'from' => $from,
            'to' => $to
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
