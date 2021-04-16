<?php

/**
* Description:
* Controller (based on MVC architecture) for all incoming requests made by user
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - redirectTo(Request $request) | redirects to the different URL based on the role of logged in user (GET method)
* - index(Request $request) | show dashboard details: draft & submitted responses
* - edit() | edit personal details
* - update(Request $request) | update personal details
* - form(Application $app) | edit application's details
* - formView(Application $app) | preview submitted response
* - destroy(Application $app) | delete draft response by user
* - faq() | show FAQ
* - draftSaved(Form $form) | save draft
* - contact() | show Contact page
* - contactSend(Request $request) | save message from Contact us page
* - 
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\ApiLog;
use App\Application;
use App\ApiCall;
use App\Setting;
use App\Faq;
use App\Form;

use Mail;

class UserController extends Controller
{

    /**
    * Description:
    * redirects to the different URL based on the role of logged in user (GET method)
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - when response is saved (not sent yet), this method is called, see the usage specified in method FormController.saveApp()
    */
    public function redirectTo(Request $request)
    {
        $user =Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        if ($user->role == 'admin') {
            return redirect('/admin/responses');
        } elseif ($user->role == 'manager') {
            return redirect('/manager/responses');
        } elseif ($user->role == 'user') {
            $redirectTo = $request->session()->get('redirectTo', '/user');
            if (!$user->email_verified_at) {
                return redirect('/user');
            }
            $request->session()->forget('redirectTo');
            return redirect($redirectTo);
        } else {
            return redirect('/user');
        }
    }


    /**
    * Description:
    * show dashboard details: draft & submitted responses
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * navigate to <baseUrl>/user
    */
    public function index(Request $request)
    {
        return view('user.index');
    }


    /**
    * Description:
    * edit personal details
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * navigate to <baseUrl>/user/edit
    */
    public function edit()
    {
        return view('user.edit', ['user' => Auth::user()]);
    }


    /**
    * Description:
    * update personal details
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * navigate to <baseUrl>/user/edit and click "Save"
    */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => Rule::unique('users')->ignore($user->id),
        ]);

        $data = $request->all();

        // Password
        if ($data['old_password']) {
            if (!Hash::check($data['old_password'], $user->password)) {
                return redirect()->route('user.edit')->with('danger', 'Wrong old password');
            }
            if (!$data['password']) {
                return redirect()->route('user.edit')->with('danger', 'Password must be setup');
            }
            $data['password'] = bcrypt($data['password']);
            unset($data['old_password']);
            unset($data['re_password']);
        } else {
            unset($data['old_password']);
            unset($data['password']);
            unset($data['re_password']);
        }

        $user->update($data);

        $api = new ApiCall;
        $data = $api->updateUser($user);
    
        return redirect()->route('user.edit')->with('success', 'User updated');
    }


    /**
    * Description:
    * edit application's details
    *
    * List of parameters:
    * - $app : Application
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * navigate to <baseUrl>/user/form/{app}
    */
    public function form(Application $app)
    {
        return view('user.form', [
            'app' => $app,
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }


    /**
    * Description:
    * preview submitted response
    *
    * List of parameters:
    * - $app : Application
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - 
    */
    public function formView(Application $app)
    {
        return view('user.form_view', [
            'app' => $app,
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }


    /**
    * Description:
    * delete draft response by user
    *
    * List of parameters:
    * - $app : Application
    *
    * Return:
    * Response: {status: 'success'}
    *
    * Examples of usage:
    * - 
    */
    public function destroy(Application $app)
    {
        $app->status = 'deleted';
        $app->save();

        ApiLog::saveLog([
            'method' => 'user delete Application',
            'user_id' => $app->user_id,
            'form_id' => $app->form_id,
            'application_id' => $app->id,
            'response' => [
                'status' => $app->status
            ]
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }




    /**
    * Description:
    * show FAQ
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * navigate to <baseUrl>/user/faq
    */
    public function faq()
    {
        return view('user.faq', [
            'user' => $user = Auth::user(),
            'faqs' => Faq::where('show', 1)->orderBy('order','asc')->get(),
        ]);
    }


    /**
    * Description:
    * save draft
    *
    * List of parameters:
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - 
    */
    protected function draftSaved(Form $form)
    {
        $msg = 'You draft "'.$form->name.'" updated.';
        return redirect()->route('user.index')->with('success', $msg);
    }


    /**
    * Description:
    * show Contact us page
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * navigate to <baseUrl>/user/contact
    */
    public function contact()
    {
        return view('user.contact', [
            'user' => $user = Auth::user()
        ]);
    }


    /**
    * Description:
    * save message from Contact us page
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * navigate to <baseUrl>/user/contact
    */
    public function contactSend(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        $msg = "<h1>".$request->get('first_name')."</h1> <h2>".$request->get('last_name')."</h2><p>".$request->get('email',false)."<p>".$request->get('message');

        $data = [];

        $feedback_email = Setting::where('key', 'feedback_email')->first();
        $from_email = Setting::where('key', 'from_email')->first();

        $data['to'] = $feedback_email ? $feedback_email->value : 'sergey.markov@gmail.com';

        $data['subject'] = 'Contact';
        $data['from_name'] = $request->get('first_name',false)." ".$request->get('last_name',false);
        $data['from_email'] = $from_email ? $from_email->value : $request->get('email',env('MAIL_USERNAME'));
        $data['message'] = $msg;
        $data['view'] = 'contact';


        Mail::send('email.'.$data['view'], ['msg' => $data['message']], function ($m) use ($data) {
          $m->from($data['from_email'], $data['from_name']);
          $m->to($data['to'])->subject($data['subject']);
        });

        return redirect()->route('user.contact')->with('success', 'Thank You');

    }

}
