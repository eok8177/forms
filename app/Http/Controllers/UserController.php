<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Application;
use App\ApiCall;
use App\Setting;

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

    public function index(Request $request)
    {
        $user =Auth::user();

        $api = new ApiCall;
        $data = $api->getDashboard($user);

        $order = $request->get('order', false);
        $dir = $request->get('dir', 'asc');

        $apps = Application::where('user_id', $user->id)
            ->join('forms', 'forms.id', '=', 'applications.form_id')
            ->join('form_types', 'form_types.id', '=', 'forms.form_type_id')
            ->where(function($q) {
                $q->orWhere('status', 'rejected');
                $q->orWhere('status', 'draft');
                // $q->orWhere(function($q) {
                //     $q->where('status', 'submitted');
                //     $q->where('to_be_approved', 1);
                // });
            });

        if ($order == 'type')   $apps->orderBy('forms.form_types.name', $dir);
        if ($order == 'status') $apps->orderBy('applications.status', $dir);
        if ($order == 'date')   $apps->orderBy('applications.updated_at', $dir);

        return view('user.index', [
            'user' => $user,
            'apps' => $apps->get(),
            'dataMars' => $data,
            'host' => $request->getHost()
        ]);
    }
	
	// public function security()
	// {
	// 	return view('user.security', ['user' => Auth::user()]);
	// }

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
	
	// public function update_security(Request $request)
	// {
	// 	$user = Auth::user();
	// 	$data = $request->all();
	// 	// Password
	// 	if ($data['old_password']) {
	// 		if (!Hash::check($data['old_password'], $user->password)) {
	// 			return redirect()->route('user.security')->with('danger', 'Wrong old password');
	// 		}
	// 		if (!$data['password']) {
	// 			return redirect()->route('user.security')->with('danger', 'Password must be setup');
	// 		}
	// 		$data['password'] = bcrypt($data['password']);
	// 		unset($data['old_password']);
	// 		unset($data['re_password']);
	// 	} else {
	// 		unset($data['old_password']);
	// 		unset($data['password']);
	// 		unset($data['re_password']);
	// 	}
	// 	$user->update($data);
	// 	return redirect()->route('user.security')->with('success', 'Security settings have been updated');
	// }

    public function form(Application $app)
    {
        return view('user.form', [
            'form' => $app,
            'settings' => Setting::pluck('value', 'key'),
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

    public function archive(Request $request)
    {
        $user = Auth::user();

        $apps = Application::where('user_id', $user->id)
            ->where(function($q) {
                $q->orWhere('status', 'accepted');
                $q->orWhere(function($q) {
                    $q->where('status', 'submitted');
                    // $q->where('to_be_approved', 0);
                });
            })
            ->get();

        return view('user.archive', [
            'user' => $user,
            'apps' => $apps,
        ]);
    }

}
