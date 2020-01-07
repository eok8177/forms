<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Form;


class AjaxController extends Controller
{
    public function status(Request $request)
    {
        if($request->ajax()){

            $model = "App\\" . $request->input('model');

            $field = $request->input('field');

            $item = $model::find($request->input('id'));

            $item->$field = 1 - $item->$field;
            $item->save();

            $response = [
                "id" => $item->id,
                "status" => $item->$field
                ];
            return json_encode($response);
        }

        return redirect()->route('admin.dashboard');
    }

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

}