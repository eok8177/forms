<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\User;


class UserController extends Controller
{
    public function index()
    {
        return view('user.index', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('user.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => Rule::unique('users')->ignore($user->id),
        ]);

        $data = $request->all();

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.edit')->with('success', 'User updated');
    }

}
