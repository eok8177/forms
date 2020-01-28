<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Application;


class UserController extends Controller
{
    public function redirectTo(Request $request)
    {
        $user =Auth::user();
        $user->last_logged_in = date("Y-m-d H:i:s");
        $user->save();
        if ($user->role == 'admin') {
            return redirect('/admin/responses');
        } elseif ($user->role == 'manager') {
            return redirect('/admin/responses');
        } elseif ($user->role == 'user') {
            $redirectTo = $request->session()->get('redirectTo', '/user');
            if (!$user->email_verified_at) {
                return redirect('/user');
            }
            $request->session()->forget('redirectTo');
            return redirect($redirectTo);
        }
    }

    public function index()
    {
        $user =Auth::user();
        return view('user.index', [
            'user' => $user,
            'apps' => Application::where('user_id', $user->id)->where('status', '!=', 'deleted')->get()
        ]);
    }
	
	public function security()
	{
		return view('user.security', ['user' => Auth::user()]);
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

        $user->update($data);

        return redirect()->route('user.edit')->with('success', 'User updated');
    }
	
	public function update_security(Request $request)
	{
		$user = Auth::user();
		$data = $request->all();
		// Password
		if ($data['old_password']) {
			if (!Hash::check($data['old_password'], $user->password)) {
				return redirect()->route('user.security')->with('danger', 'Wrong old password');
			}
			if (!$data['password']) {
				return redirect()->route('user.security')->with('danger', 'Password must be setup');
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
		return redirect()->route('user.security')->with('success', 'Security settings have been updated');
	}

    public function form(Application $app)
    {
        return view('user.form', [
            'form' => $app
        ]);
    }

    public function destroy(Application $app)
    {
        $app->status = 'deleted';
        $app->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

}
