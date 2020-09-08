<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Group;
use App\ApiCall;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role == 'manager') {
            return redirect()->route('admin.dashboard');
        }

        $roles = [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'user' => 'Applicant',
        ];

        $role = $request->input('role', false);
        $users = User::orderBy('id','asc');

        if ($role) {
            $users->where('role', '=', $role);
        }

        return view('admin.user.index', [
            'users' => $users->get(),
            'role' => $role,
            'roles' => $roles
        ]);
    }

    public function create()
    {
        if (Auth::user()->role == 'manager') {
            return redirect()->route('admin.dashboard');
        }
        $user = new User;
        $user->role = 'manager';
        return view('admin.user.create', [
            'user' => $user,
            'groups' => Group::all(),
            'readonly' => false
        ]);
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'login' => 'required|unique:users',
        ]);

        $data = $request->except('groups');

        if (!$data['password']) {
            $data['password'] = bcrypt('123456');
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $email_verified = $data['email_verified'];
        unset($data['email_verified']);
        if ($email_verified == 1) {
            $data['email_verified_at'] = date('yy-m-d h:i:s');
        }

        $user = $user->create($data);

        $user->update($data);

        $api = new ApiCall;
        $data = $api->newUser($user);

        // Groups attach
        if ($request->has('groups')) {
            $user->groups()->attach($request->input('groups'));
        }

        return redirect()->route('admin.user.index')->with('success', 'User created');
    }

    public function show(User $user)
    {
        return redirect()->route('admin.user.index');
    }

    public function edit(User $user)
    {
        $readonly = false;
        // restrict edit other users by manager
        if (Auth::user()->role == 'manager' && Auth::user()->id != $user->id) {
            return redirect()->route('admin.dashboard');
        }
        // for admin
        if (Auth::user()->role == 'admin') {
            if ($user->email_verified_at != NULL) $readonly = true;

            if (Auth::user()->super_admin_to > date("Y-m-d H:i:s")) $readonly = false;
        }
        return view('admin.user.edit', [
            'user' => $user,
            'groups' => Group::all(),
            'readonly' => $readonly
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => Rule::unique('users')->ignore($user->id),
            'login' => Rule::unique('users')->ignore($user->id),
        ]);

        $data = $request->except('groups');

        if ($request->has('password') && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $email_verified = $data['email_verified'];
        unset($data['email_verified']);
        if ($email_verified == 1 && $user->email_verified_at == NULL) {
            $data['email_verified_at'] = date('yy-m-d h:i:s');
        } elseif ($email_verified == 0) {
            $data['email_verified_at'] = NULL;
        }

        $user->update($data);
        $api = new ApiCall;
        $data = $api->updateUser($user);

        if (Auth::user()->role == 'admin') {
            $user->groups()->detach();
            // Groups attach
            if ($request->has('groups')) {
                $user->groups()->attach($request->input('groups'));
            }
        }


        return redirect()->route('admin.user.edit', ['user' => $user->id])->with('success', 'User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function setSAdmin(Request $request)
    {
        $password = $request->input('password', false);
        if ($password == env('SADMIN_PASSWORD', 'Mon@2408!PT123456')) {

            $time_to = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $user = Auth::user();
            $user->super_admin_to = $time_to;
            $user->save();
            return redirect()->route('admin.user.index')->with('success', 'You got super-admin`s privileges on One hour');
        }
        return redirect()->route('admin.user.index')->with('danger', 'Wrong password');
    }

    public function sendVerifyEmail($id)
    {
        $user = User::find($id);
        $user->sendVerifyEmail();

        return response()->json('success', 200);
    }
}
