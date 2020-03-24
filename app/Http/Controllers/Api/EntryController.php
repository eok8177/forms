<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Entry;

class EntryController extends Controller
{
    public function test(Request $request)
    {
        return response()->json([
            'type' => 'Get',
            'status' => 'OK',
            'user' => $request->user()
        ], 200);
    }

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


    /*
    *  Call api like this method:
    *
    *  $ curl -X POST localhost:8000/api/entries \
    *   -H "Content-type: application/json" \
    *   -H "Authorization: Bearer [api_token]"
    *
    *   api_token - from DB users.api_token
    */


    /*
    * Response Codes:
    *    200: OK. The standard success code and default option.
    *    201: Object created. Useful for the store actions.
    *    204: No content. When an action was executed successfully, but there is no content to return.
    *    206: Partial content. Useful when you have to return a paginated list of resources.
    *    400: Bad request. The standard option for requests that fail to pass validation.
    *    401: Unauthorized. The user needs to be authenticated.
    *    403: Forbidden. The user is authenticated, but does not have the permissions to perform an action.
    *    404: Not found. This will be returned automatically by Laravel when the resource is not found.
    *    500: Internal server error. Ideally you're not going to be explicitly returning this, but if something unexpected breaks, this is what your user is going to receive.
    *    503: Service unavailable. Pretty self explanatory, but also another code that is not going to be returned explicitly by the application.
    */