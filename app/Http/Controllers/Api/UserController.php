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
        $data = $api->newUser($user);

        return response()->json([
            'type' => 'Get',
            'status' => 'OK',
            'data' => $data
        ], 200);
    }

}