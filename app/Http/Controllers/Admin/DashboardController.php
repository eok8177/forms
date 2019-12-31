<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $form_id = $request->input('id', false);

        $forms = Entry::select('form_id')->distinct()->pluck('form_id')->toArray();
        $select_forms = Form::whereIn('id',$forms)->pluck('title', 'id');

        $selected_form_name = $form_id ? $select_forms->toArray()[$form_id] : 'All Forms';
        $entriesWhere = $form_id ? Entry::where('form_id', $form_id) : Entry::where('form_id', '>', 0);
        $entries = $entriesWhere->select('entry_id', 'form_id', 'created_at')->distinct()->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', [
            'entries' => $entries,
            'forms' => Form::pluck('title', 'id'),
            'select_forms' => $select_forms,
            'selected_form_name' => $selected_form_name
        ]);
    }

    public function entry($entry)
    {
        $entries = Entry::where('entry_id', $entry)->get();
        return view('admin.entry', [
            'entries' => $entries
        ]);
    }
}
