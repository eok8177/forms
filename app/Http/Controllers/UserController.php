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
            'apps' => Application::where('user_id', $user->id)->where('status', '!=', 'deleted')->get(),
            'test' => $this->test_data
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



    private $test_data = [
        [
            "Reference" => "2999",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-12-20 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3000",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-05-09 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3001",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-30 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3002",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-11-10 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3003",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-10-21 00:00:00.000",
            "Status" => "Pending Payment",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3004",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-01-29 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3005",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-01-09 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3006",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-04-19 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3008",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-02-18 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3010",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-11-30 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3011",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-10 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3102",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-12 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3103",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-01-17 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3104",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-11-24 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3105",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-06-28 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3106",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-05-05 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3107",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-11-04 00:00:00.000",
            "Status" => "Attended",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3108",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-06-30 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3109",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-05-27 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3110",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-04-23 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3111",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-02-14 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3112",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-20 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3113",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-12-08 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3114",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-01-11 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3115",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-12-30 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3116",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-06-28 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3117",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-05-14 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3118",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2017-11-15 00:00:00.000",
            "Status" => "Pending Payment",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3119",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-30 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3120",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-02-13 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3128",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-02-13 00:00:00.000",
            "Status" => "Attended",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3129",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-04-08 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3130",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-21 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3131",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-06-01 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3133",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-05-05 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3134",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-12 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3135",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-21 00:00:00.000",
            "Status" => "Attended",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3136",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-06-28 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3172",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-04-23 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3173",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-03-20 00:00:00.000",
            "Status" => "Attended",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3175",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-05-16 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ],
        [
            "Reference" => "3291",
            "Type" => "Outreach Visit",
            "Details" => null,
            "Date" => "2018-12-14 00:00:00.000",
            "Status" => "Booked",
            "action_edit" => "Y",
            "action_delete" => "N",
            "action_accept" => "N",
            "action_decline" => "N"
        ]
    ];
}
