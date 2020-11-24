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
        return view('home', ['forms' => Form::search(false,0,0)->get()]);
    }

    public function success(Request $request, $id)
    {
        $form = Form::find($id);
        $msg = "Thank you ".Auth::user()->name;

        $request->session()->flash('success', $msg);

        return view('success', [
            'forms' => Form::search(false,0,0)->get(),
            'form' => $form
        ]);
    }

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

    public function allForms()
    {
        return view('all_forms', ['forms' => Form::search(false,0,0)->get()]);
    }

}
