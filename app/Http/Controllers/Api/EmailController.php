<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

use App\User;
use App\Setting;

class EmailController extends Controller
{
    public function feedback(Request $request)
    {
        $msg = $request->get('text');
        $user_id = $request->get('user', false);

        $user = User::find($user_id);

        $data = [];

        $data['to'] = Setting::where('key', 'feedback_email')->first()->value;

        $data['subject'] = 'Rwav Feedback';

        if($user) {
            $data['from_name'] = $user->first_name." ".$user->last_name;
            $data['from_email'] = $user->email;
        } else {
            $data['from_name'] = "Guest";
            $data['from_email'] = $data['to'];
        }

        $data['message'] = $msg;
        $data['view'] = 'feedback';

        Mail::send('email.'.$data['view'], ['msg' => $data['message']], function ($m) use ($data) {
          $m->from($data['from_email'], $data['from_name']);
          $m->to($data['to'])->subject($data['subject']);
        });

        return response()->json([
            'status' => 'OK',
            // 'status' => 'error',
            // 'error' => 'something wrong',
        ], 200);
    }
}