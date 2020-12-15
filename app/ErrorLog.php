<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class ErrorLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static function log($data)
    {
        $user_id = null;
        if ($user = auth()->user()) $user_id = $user->id;

        $ip_address = request()->ip();
        $user_agent = request()->header('User-Agent');

        $payload = json_encode($data);

        $log = new ErrorLog;
        $log->user_id = $user_id;
        $log->ip_address = $ip_address;
        $log->user_agent = $user_agent;
        $log->payload = $payload;
        $log->save();


        // admin_submit
        $admin_email = Setting::where('key', 'feedback_email')->first()->value;

        $data = [
            'to' => $admin_email,
            'subject' => 'ErrorLog',
            'from_name' => 'RVAW',
            'from_email' => $admin_email,
            'message' => $log,
            'view' => 'error',
        ];

        Mail::send('email.'.$data['view'], ['msg' => $data['message']], function ($m) use ($data) {
          $m->from($data['from_email'], $data['from_name']);
          $m->to($data['to'])->subject($data['subject']);
        });


        return $log;
    }

}
