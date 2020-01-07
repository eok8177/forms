<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Group;


class UserController extends Controller
{
    public function index()
    {
        // return redirect()->route('admin.dashboard');
        return view('admin.user.index', ['users' => User::all()]);
    }

    public function create()
    {
        // return redirect()->route('admin.dashboard');
        return view('admin.user.create', [
            'user' => new User,
            'groups' => Group::all()
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
        return view('admin.user.edit', [
            'user' => $user,
            'groups' => Group::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => Rule::unique('users')->ignore($user->id),
        ]);

        $data = $request->except('groups');

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        $user->groups()->detach();
        // Groups attach
        if ($request->has('groups')) {
            $user->groups()->attach($request->input('groups'));
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
}
