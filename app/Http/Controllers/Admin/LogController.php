<?php

/**
* Description:
* Controller (based on MVC architecture) for the management of logs
* All the methods are available only for the admin
* 
* List of methods:
* - index() | Show the list of all logs (currently not used)
* - apilogs() | Show list of only failed logs
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Form;
use App\ApiLog;


class LogController extends Controller
{

    /**
    * Description:
    * Show the list of all logs (currently not used)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - 
    */
    public function index()
    {
        $logs = ApiLog::where('status', 1)->orderBy('id','asc');
        return view('admin.logs.index', [
            'logs' => $logs->get(),
        ]);
    }


    /**
    * Description:
    * Show list of only failed logs
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/apilogs
    */
    public function apilogs()
    {
        $logs = ApiLog::failled();
        return view('admin.logs.index', [
            'logs' => $logs,
        ]);
    }

}