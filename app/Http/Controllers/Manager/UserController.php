<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'email' => Rule::unique('users')->ignore($user->id),
        ]);

        $data = $request->all();

        if ($request->has('password') && $data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $api = new ApiCall;
        $data = $api->updateUser($user);

        return redirect()->route('manager.user.edit', ['user' => $user->id])->with('success', 'Profile updated');
    }

}
