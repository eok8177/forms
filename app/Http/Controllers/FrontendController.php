<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Form;

class FrontendController extends Controller
{
    public function index()
    {
        return view('home', ['forms' => Form::where('is_active', 1)->get()]);
    }

    public function success()
    {
        return view('success', ['forms' => Form::where('is_active', 1)->get()]);
    }

    public function form($id)
    {
        return view('form', [
            'forms' => Form::where('is_active', 1)->get(),
            'form' => Form::find($id)
        ]);
    }

}
