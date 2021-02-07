<?php

/**
* Description:
* Controller (based on MVC architecture) for the management of users
* All the methods are available only for the admin
* 
* List of methods:
* - index(Request $request) | Show list of users
* - create() | Create new user details
* - store(Request $request, User $user) | Store just created new user details (POST method)
* - show(User $user)
* - edit(User $user) | Edit user's details
* - update(Request $request, User $user) | Update user's details page (PUT method)
* - destroy(User $user) | Delete user details (DELETE method)
* - setSAdmin(Request $request) | Set super-admin privileges for the admin
* - sendVerifyEmail($id) | Send verification email to the user
*/

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

    /**
    * Description:
    * Show list of users
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/user
    */
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


    /**
    * Description:
    * Create new user details
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/user/create
    */
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


    /**
    * Description:
    * Store just created new user details (POST method)
    *
    * List of parameters:
    * - $request : Request
    * - $user: User
    *
    * Return:
    * view content, redirects to the list of users
    *
    * Examples of usage:
    * - create new user page, prefill it and click "Save"
    */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
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
            $data['email_verified_at'] = date('Y-m-d h:i:s');
        }

        $user = $user->create($data);

        $user->update($data);

        $api = new ApiCall;
        $user->active_user_id = Auth::user()->id;
        $data = $api->newUser($user);

        // Groups attach
        if ($request->has('groups')) {
            $user->groups()->attach($request->input('groups'));
        }

        return redirect()->route('admin.user.index')->with('success', 'User created');
    }


    /**
    * Description:
    * TOREVIEW
    *
    * List of parameters:
    * - $user : User
    *
    * Return:
    * 
    *
    * Examples of usage:
    * - 
    */
    public function show(User $user)
    {
        return redirect()->route('admin.user.index');
    }


    /**
    * Description:
    * Edit user's details
    *
    * List of parameters:
    * - $user : User
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/user/2/edit
    */
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


    /**
    * Description:
    * Update user's details page (PUT method)
    *
    * List of parameters:
    * - $request : Request
    * - $user : User
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/user/2/edit and click "Save"
    */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => Rule::unique('users')->ignore($user->id),
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
            $data['email_verified_at'] = date('Y-m-d h:i:s');
        } elseif ($email_verified == 0) {
            $data['email_verified_at'] = NULL;
        }

        $user->update($data);
        $api = new ApiCall;
        $user->active_user_id = Auth::user()->id;
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


    /**
    * Description:
    * Delete user details (DELETE method)
    *
    * List of parameters:
    * - $user : User
    *
    * Return:
    * Response: {status: 'success'}
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/user and click to trash icon at any item in the list
    */
    public function destroy(User $user)
    {
        $api = new ApiCall;
        $user->active_user_id = Auth::user()->id;
        $data = $api->deleteUser($user);

        $user->email = $user->email.'_'.time();
        $user->save();

        $user->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }


    /**
    * Description:
    * Set super-admin privileges for the admin
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/user and type in the password at the top-right corner
    * then click to "set admin privileges" button
    */
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


    /**
    * Description:
    * Send verification email to the user
    *
    * List of parameters:
    * - $id : integer
    *
    * Return:
    * Response: {'success'}
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/user and click to envelope icon in the list
    */
    public function sendVerifyEmail($id)
    {
        $user = User::find($id);
        $user->sendEmailVerificationNotification();

        return response()->json('success', 200);
    }
}
