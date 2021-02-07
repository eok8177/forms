<?php

/**
* Description:
* Controller (based on MVC architecture) to manage manager's personal details
* 
* List of methods:
* - edit(User $user) | Edit personal details by manager
* - update(Request $request, User $user) | Update manager's personal details (PUT method)
*
*/

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

    /**
    * Description:
    * Edit personal details by manager
    *
    * List of parameters:
    * - $user : User
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>manager/user/16/edit
    */
    public function edit(User $user)
    {
        // prevent edit other users details by the manager
        if (Auth::user()->id != $user->id) {
            return redirect()->route('manager.responses');
        }

        return view('manager.profile', [
            'user' => $user
        ]);
    }


    /**
    * Description:
    * Update manager's personal details (PUT method)
    *
    * List of parameters:
    * - $request : Request
    * - $user : User
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/manager/user/16/edit and click "Save"
    */
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
