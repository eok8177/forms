<?php

/**
* Description:
* 
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\ApiCall;
use App\Application;


class GrantController extends Controller
{
    /**
    * Description:
    * 
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * 
    */
    public function index(Request $request)
    {
        $user =Auth::user();

        $api = new ApiCall;
        $data = $api->getDashboard($user);

        $order = $request->get('order', 'date');
        $dir = $request->get('dir', 'desc');

        $apps = Application::where('user_id', $user->id)
            ->join('forms', 'forms.id', '=', 'applications.form_id')
            ->join('form_types', 'form_types.id', '=', 'forms.form_type_id')
            ->select('applications.*')
            ->where(function($q) {
                $q->orWhere('status', 'rejected');
                $q->orWhere('status', 'draft');
            });

        $submitted = Application::where('user_id', $user->id)
            ->join('forms', 'forms.id', '=', 'applications.form_id')
            ->join('form_types', 'form_types.id', '=', 'forms.form_type_id')
            ->select('applications.*')
            ->where(function($q) {
                $q->orWhere('status', 'accepted');
                $q->orWhere(function($q) {
                    $q->where('status', 'submitted');
                });
            });

        if ($order == 'type') {
            $apps->orderBy('forms.form_types.name', $dir);
            $submitted->orderBy('forms.form_types.name', $dir);
        }
        if ($order == 'status') {
            $apps->orderBy('applications.status', $dir);
            $submitted->orderBy('applications.status', $dir);
        }
        if ($order == 'date') {
            $apps->orderBy('applications.updated_at', $dir);
            $submitted->orderBy('applications.updated_at', $dir);
        }

        return view('user.grants', [
            'user' => $user,
            'apps' => $apps->get(),
            'submitted' => $submitted->get(),
            'dataMars' => $data,
            'host' => $request->getHost()
        ]);
    }

}
