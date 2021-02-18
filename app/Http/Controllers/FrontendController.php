<?php

/**
* Description:
* Controller (based on MVC architecture) for all front-end requests
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - success(Request $request, $id) | method to show "Thank you <logged-in user>" succesful message at <baseUrl>/success/{id}  (GET method)
* - form(Request $request, $id) | method to show form definition at <baseUrl>/form/{id?} (GET method)
* - allForms() | show all non-trashed not-draft forms at <baseUrl>/all-forms (GET method)
* - RegisterThankYou() | navigate to "thank you for the registration" page (GET method)
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Application;
use App\Form;
use App\Setting;

class FrontendController extends Controller
{
    public function index()
    {
        return view('home', ['forms' => Form::search(false,0,0)->get()]);
    }

    /**
    * Description:
    * method to show "Thank you <logged-in user>" succesful message at <baseUrl>/success/{id}  (GET method)
    *
    * List of parameters:
    * - $request : Request
    * - $id : int
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - when response is saved (not sent yet), this method is called, see the usage specified in method FormController.saveApp()
    */
    public function success(Request $request, $id)
    {
        $app = Application::find($id);
        if (!$app) {
            return redirect('/');
        }
        $msg = "Thank you ".$app->user->name;

        $request->session()->flash('success', $msg);

        return view('success', [
            'forms' => Form::search(false,0,0)->get(),
            'form' => $app->form
        ]);
    }


    /**
    * Description:
    * method to show form definition at <baseUrl>/form/{id?}, some forms can be viewed only by logged-in users (GET method)
    *
    * List of parameters:
    * - $request : Request
    * - $slug : string
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - 
    */
    public function form(Request $request, $slug = '')
    {
        $form = Form::where('slug', $slug)
            ->with('types', 'groups', 'apps')
            ->withCount(['groups', 'apps'])
            ->first();
        $user = Auth::user();

        if ($form && $form->login_only == 1) {
            if (!$user) {
                $request->session()->put('redirectTo', '/form/'.$slug);
                return redirect()->route('login');
            } elseif ($user->email_verified_at == NULL) {
                return redirect()->route('verification.notice');
            }
        }

        return view('form', [
            'forms' => Form::search(false,0,0)->get(),
            'form' => $form,
            'settings' => Setting::pluck('value', 'key'),
            'user' => $user
        ]);
    }


    /**
    * Description:
    * show all non-trashed not-draft forms at <baseUrl>/all-forms (GET method)
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - https://myrwav.rwav.com.au/all-forms
    */
    public function allForms()
    {
        return view('all_forms', ['forms' => Form::search(false,0,0)->get()]);
    }

}
