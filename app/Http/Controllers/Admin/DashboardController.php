<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Application;
use App\Entry;
use App\Form;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $form_id = $request->input('id', 0);
        $status = $request->input('status', Application::STATUS_SUBMITTED);

        $forms = Application::select('form_id')->distinct()->pluck('form_id')->toArray();

        $entries = Application::orderBy('created_at', 'desc');

        if ($form_id > 0) {
            $entries->where('form_id', $form_id);
        }

        if ($status != Application::STATUS_ALL) {
            $entries->where('status', $status);
        }

        if ($user->role == 'manager') {
            $groupIds = $user->groups->pluck('id')->toArray();
            $forms = Form::whereHas('groups', function($q) use ($groupIds) {
                $q->whereIn('group_id', $groupIds);
            })->pluck('id')->toArray();
            $entries->whereIn('form_id', $forms);
        }

        $select_forms = [0 =>'All Forms'] + Form::whereIn('id',$forms)->pluck('title', 'id')->all();

        return view('admin.dashboard', [
            'entries' => $entries->get(),
            'select_forms' => $select_forms,
            'form_id' => $form_id,
            'status' => $status
        ]);
    }

    public function entry($entry)
    {
        $entries = Entry::where('entry_id', $entry)->get();
        $form = Form::where('id', $entries->first()->form_id)->first();
        return view('admin.entry', [
            'entries' => $entries,
            'form' => $form
        ]);
    }

    public function status($entry, $status)
    {
        $app = Application::where('entry_id', $entry)->first();
        $app->status = $status;
        $app->save();

        return redirect()->route('admin.dashboard');
    }
}
