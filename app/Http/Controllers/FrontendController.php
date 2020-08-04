<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Form;
use App\Setting;

class FrontendController extends Controller
{
    public function index()
    {
        return view('home', ['forms' => Form::where('draft', 0)->get()]);
    }

    public function success($id)
    {
        $form = Form::find($id);
        return view('success', [
            'forms' => Form::where('draft', 0)->get(),
            'form' => $form
        ]);
    }

    public function form(Request $request, $slug = '')
    {
        $form = Form::where('slug', $slug)->first();
        $user = Auth::user();

        if ($form && $form->login_only == 1 && !$user) {
            $request->session()->put('redirectTo', '/form/'.$slug);
            return redirect()->route('login');
        }

        return view('form', [
            'forms' => Form::where('draft', 0)->get(),
            'form' => $form,
            'settings' => Setting::pluck('value', 'key'),
            'user' => $user
        ]);
    }

    public function allForms()
    {
        return view('all_forms', ['forms' => Form::search(false,0,0)->get()]);
    }

}
