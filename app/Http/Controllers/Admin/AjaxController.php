<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AjaxController extends Controller
{
    public function status(Request $request)
    {
        if($request->ajax()){

            if ($request->input('model') == 'User') {
                $model = "App\User";
            } else {
                $model = "App\Model\\" . $request->input('model');
            }

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
                $model = "App\Model\\" . $request->input('model');
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
            return json_encode($response);
        }

        return redirect()->route('admin.dashboard');
    }

}