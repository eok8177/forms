<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Group;
use App\ApiCall;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit(User $user)
    {
        // restrict edit other users by manager
        if (Auth::user()->id != $user->id) {
            return redirect()->route('manager.responses');
        }

        return view('manager.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => Rule::unique('users')->ignore($user->id),
        ]);

        $data = $request->all();

        // Password
        if ($data['old_password']) {
            if (!Hash::check($data['old_password'], $user->password)) {
                return redirect()->route('manager.user.edit', ['user' => $user->id])->with('danger', 'Wrong old password');
            }
            if (!$data['password']) {
                return redirect()->route('manager.user.edit', ['user' => $user->id])->with('danger', 'Password must be setup');
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

        return redirect()->route('manager.user.edit', ['user' => $user->id])->with('success', 'Profile updated');
    }

}
