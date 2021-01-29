<?php

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

    static function failled()
    {
        $logs = ApiLog::where('response','LIKE', '%"response_status":"0"%')->get();

        return $logs;
    }

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
