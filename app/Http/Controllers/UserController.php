<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Application;


class UserController extends Controller
{
    public function index()
    {
        $user =Auth::user();
        return view('user.index', [
            'user' => $user,
            'apps' => Application::where('user_id', $user->id)->get()
        ]);
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

    public function form(Application $app)
    {
        return view('user.form', [
            'form' => $app
        ]);
    }

}
