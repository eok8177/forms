<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Group;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'manager') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.user.index', ['users' => User::where('role','!=','user')->get()]);
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
        ]);

        $data = $request->except('groups');

        if (!$data['password']) {
            $data['password'] = bcrypt('123456');
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user = $user->create($data);

        $user->update($data);

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
        ]);

        $data = $request->except('groups');

        if ($request->has('password') && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

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
        if ($password == '123456') { // TODO what password ro use?

            $time_to = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $user = Auth::user();
            $user->super_admin_to = $time_to;
            $user->save();
            return redirect()->route('admin.user.index')->with('success', 'You now super Admin until: '.$time_to);
        }
        return redirect()->route('admin.user.index')->with('danger', 'Wrong password');
    }
}
