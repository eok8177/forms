<?php

/**
* Description:
* Controller (based on MVC architecture) for all email related routines
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - feedback(Request $request)
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

use App\User;
use App\Setting;

class EmailController extends Controller
{

    /**
    * Description:
    * Sends feedback email to the admin (Currently disabled on the website)
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * Response: status code = 200, {status: 'OK'}
    *
    * Examples of usage:
    * - Admin's email is defined as settings.feedback_email value
    */
    public function feedback(Request $request)
    {
        $msg = $request->get('text');
        $user_id = $request->get('user', false);

        $user = User::find($user_id);

        $data = [];

        $data['to'] = Setting::where('key', 'feedback_email')->first()->value;

        $data['subject'] = 'RWAV Feedback';

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
        ], 200);
    }
}