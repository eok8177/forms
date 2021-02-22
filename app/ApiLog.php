<?php

/**
* Description:
* Model (based on MVC architecture) with all API logs
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - failled() | get list of all failed logs
* - saveLog($data) | create new record in API logs
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    const UPDATED_AT = null; //and updated by default null set

    /**
    * Description:
    * get list of all failed logs
    *
    * List of parameters:
    * - none
    *
    * Return:
    * 
    * Example of usage:
    * see method Http/Controllers/Admin/LogController.apilogs()
    */
    static function failled()
    {
        $logs = ApiLog::where('response','LIKE', '%"response_status":"0"%')->get();

        return $logs;
    }


    /**
    * Description:
    * create new record in API logs
    *
    * List of parameters:
    * $data : object
    *
    * Return:
    * 
    * Example of usage:
    * see method Http/Controllers/Manager/ResponseController.status()
    */
    static function saveLog($data)
    {
        $log = new ApiLog;

        $log->method = array_key_exists('method', $data) ? $data['method'] : NULL;
        $log->user_id = array_key_exists('user_id', $data) ? $data['user_id'] : NULL;
        $log->form_id = array_key_exists('form_id', $data) ? $data['form_id'] : NULL;
        $log->application_id = array_key_exists('application_id', $data) ? $data['application_id'] : NULL;
        $log->payload = array_key_exists('payload', $data) ? json_encode($data['payload']) : NULL;
        $log->response = array_key_exists('response', $data) ? json_encode($data['response']) : NULL;
        $log->status = array_key_exists('status', $data) ? $data['status'] : 0;
        $log->save();

        return $log;
    }

}
