<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Entry;
use App\Form;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Entry::select('entry_id', 'form_id')->distinct()->get();
        return view('admin.dashboard', [
            'entries' => $entries,
            'forms' => Form::pluck('title', 'id')
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
