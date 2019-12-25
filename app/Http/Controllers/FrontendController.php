<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Form;

class FrontendController extends Controller
{
    public function index()
    {
        return view('home', ['forms' => Form::where('is_active', 1)->get()]);
    }

    public function success($id)
    {
        $form = Form::find($id);
        return view('success', [
            'forms' => Form::where('is_active', 1)->get(),
            'form' => $form
        ]);
    }

    public function form(Request $request, $id)
    {
        $form = Form::find($id);

        if ($form->login_only == 1 && !Auth::user()) {
            $request->session()->put('redirectTo', '/form/'.$id);
            return redirect()->route('login');
        }

        return view('form', [
            'forms' => Form::where('is_active', 1)->get(),
            'form' => $form
        ]);
    }

}
