<?php

/**
* Description:
* Controller (based on MVC architecture) for entries
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - test(Request $request) | Generates dummy response (for debug purposes only)
* - index(Request $request)
* - 
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entry;

class EntryController extends Controller
{

    /**
    * Description:
    * Generates dummy response (for debug purposes only)
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * Response: status=200, {type: 'Get', status: 'OK', user: <user's details>}
    *
    * Examples of usage:
    * - 
    */
    public function test(Request $request)
    {
        return response()->json([
            'type' => 'Get',
            'status' => 'OK',
            'user' => $request->user()
        ], 200);
    }


    /**
    * Description:
    * TOREVIEW
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * 
    *
    * Examples of usage:
    * - 
    */
    public function index(Request $request)
    {
        // TODO if need get entries only by user privilegies
        // $user = $request->user();

        $from_date = $request->get('from', false);

        $entry_ids = Entry::orderBy('id','asc');

        if ($from_date) {
            $entry_ids->where('created_at','>=',$from_date);
        }

        $entry_ids = $entry_ids->groupBy('entry_id')->pluck('entry_id');

        $entries = [];

        foreach ($entry_ids as $entry_id) {
            $entry_tmp = Entry::where('entry_id',$entry_id)->first();
            $entries[$entry_id]['form_id'] = $entry_tmp->form->id;
            $entries[$entry_id]['form_name'] = $entry_tmp->form->name;
            $entries[$entry_id]['form_date'] = "".$entry_tmp->created_at;

            $entries[$entry_id]['data'] = Entry::where('entry_id',$entry_id)
                ->get(['name','value','field_id']);
        }


        return response()->json([
            'status' => 'OK',
            'count' => $entry_ids->count(),
            'data' => $entries
        ], 200);
    }

}
