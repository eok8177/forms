<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Form;
use App\ApiLog;


class LogController extends Controller
{
    public function index()
    {
        $logs = ApiLog::where('status', 1)->orderBy('id','asc');
        return view('admin.logs.index', [
            'logs' => $logs->get(),
        ]);
    }

    public function apilogs()
    {
        $logs = ApiLog::failled();
        return view('admin.logs.index', [
            'logs' => $logs,
        ]);
    }

}