<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting', [
            'settings' => Setting::all()
        ]);
    }


    public function update(Request $request)
    {
        Setting::updateSettings($request->except('_token'));
        return redirect()->route('admin.settings')->with('success', 'Updated');
    }

}
