<?php

/**
* Description:
* Controller (based on MVC architecture) for all AJAX calls
* 
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
*
* List of methods:
* - status(Request $request) | Change status of the form to live/draft
* - reorder(Request $request)
* - form(Request $request, $id)
* - setTime(Request $request)
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Form;
use App\ApiCall;

class AjaxController extends Controller
{

    /**
    * Description:
    * Change status of the form to live/draft
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * JSON: {id: $id, status: <new status ID>}
    *
    * Examples of usage:
    * Login as an admin, go to "Forms", under Actions it's available by clicking to circle icon
    */
    public function status(Request $request)
    {
        if($request->ajax()){

            $model = "App\\" . $request->input('model');

            $field = $request->input('field');

            $item = $model::find($request->input('id'));

            $item->$field = 1 - $item->$field;
            $item->save();

			// if form set to live (forms.draft == 0)
			if ($request->input('model') == 'Form' && $item->$field == 0) {
				$form = Form::find($request->input('id'));
				if ($form) {
					$fieldsArray = $form->getFieldsData();
					$formData = (object)[
						'portal_form_id' => $request->input('id'), 
						'portal_form_name' => $form->name
						];
					$formData->portal_fields = json_encode($fieldsArray);
					// pass Portal Form definition into MARS
					$api = new ApiCall;
					$data = $api->newUpdateForm($formData);
				}
			}

            $response = [
                "id" => $item->id,
                "status" => $item->$field
                ];
            return json_encode($response);
        }

        return redirect()->route('admin.dashboard');
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
    public function reorder(Request $request)
    {
        if($request->ajax()){

            if ($request->input('model') == 'User') {
                $model = "App\User";
            } else {
                $model = "App\\" . $request->input('model');
            }

            $order = $request->input('order');
            $i = 1;
            foreach ($order as $item) {
                $record = $model::find($item['id']);
                $record->order = $i;
                $record->save();
                $i++;
            }

            $response = [
                "status" => "reordered"
                ];
            return response()->json($response, 200);
        }

        return redirect()->route('admin.dashboard');
    }


    /**
    * Description:
    * TOREVIEW
    *
    * List of parameters:
    * - $request : Request
    * - $id : integer
    *
    * Return:
    * 
    *
    * Examples of usage:
    * - 
    */
    public function form(Request $request, $id)
    {

        $data = $request->input('data', false);

        if ($data) {
            $form = Form::find($id);
            $form->config = $data;
            $form->save();
            return response()->json($form, 200);
        }
        return response()->json($data, 400);

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
    public function setTime(Request $request)
    {
        if($request->ajax()){

            $model = "App\\" . $request->input('model');

            $field = $request->input('field');

            $item = $model::find($request->input('id'));

            $item->$field = $item->$field == NULL ? date('Y-m-d h:i:s') : NULL;
            $item->save();

            $response = [
                "id" => $item->id,
                "status" => $item->$field != NULL
                ];
            return json_encode($response);
        }

        return redirect()->route('admin.dashboard');
    }

}