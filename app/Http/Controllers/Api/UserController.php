<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\ApiCall;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // TODO if need get entries only by user privilegies
        // $user = $request->user();

        $from_date = $request->get('from', false);

        $users = User::orderBy('id','asc');

        if ($from_date) {
            $users->where('updated_at','>=',$from_date);
        }

        return response()->json([
            'status' => 'OK',
            'count' => $users->count(),
            'data' => $users->get()
        ], 200);
    }

    public function test(Request $request)
    {
        $user_id = $request->get('user', false);

        if ($user_id) {
            $user = User::where('id',$user_id)->firstOrFail();
        }

        $api = new ApiCall;
        $data = $api->newUser($this->test_data);

        return response()->json([
            'type' => 'Get',
            'status' => 'OK',
            'data' => $data
        ], 200);
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