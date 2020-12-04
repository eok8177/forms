<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Form;
use App\Entry;
use App\Application;


class FormController extends Controller
{
    public function index()
    {
        return response()->json([
            'type' => 'Get',
            'status' => 'OK',
        ], 200);
    }

    public function saveApp(Request $request)
    {
        $appid = $request->get('appid', 0);
        $userid = $request->get('userid', 0);
        $formid = $request->get('formid');
        $status = $request->get('status');
        $entryid = $request->get('entryid', NULL);
        $data = $request->input('data', false);

        $app = Application::where('id', $appid)->first();

        if ($appid == 0) {
            $app = new Application;
        }

        $form = Form::where('id', $formid)->first();

        $app->user_id = $userid;
        $app->form_id = $formid;
        $app->status = $status;
        $app->entry_id = $entryid;
        $app->config = json_encode($data);
        $app->to_be_approved = $form->to_be_approved;
        $app->save();

        $app->additional_field_value = $app->additional_field;
        $app->save();

        return response()->json([
            'status' => 'OK',
            'appid' => $app->id,
            'redirect_url' => $form->redirect_url ? $form->redirect_url : '/success/'.$formid,
        ], 200);
    }

    public function uploadFile(Request $request)
    {
        $appid = $request->get('appid', 0);
        $fieldId = $request->get('fieldId');
        $formId = $request->get('formId');
        if ($fieldName = $request->get('fieldName')) {
            $file = $request->file;
            $filename = $file->storeAs('uploads/'.$formId.'/'.$appid, $file->getClientOriginalName(), 'public');

            $app = Application::where('id', $appid)->first();
            if ($app) {
                $app->updateConfig($fieldId, $filename);

                return response()->json([
                    'status' => 'OK',
                    'file' => $filename,
                    'fieldId' => $fieldId,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'not found file',
        ], 400);
    }

    public function postForm(Request $request)
    {
        $appid = $request->get('appid', 0);
        $app = Application::find($appid);

        $app->createEntry();
        if ($app->to_be_approved == 0) {
            $app->adminSubmitEmail();
        } else {
            $app->managerSubmitEmail();
        }
        // send email to user regardless response is needed to be approved/rejected
        $app->userSubmitEmail();

        return response()->json([
            'status' => 'OK'
        ], 200);
    }

    public function getCoords(Request $request)
    {
        $key = $request->get('key', false);
        $address = $request->get('address', false);
        $address = urlencode($address);

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?sensor=false&key='.$key.'&address='.$address;

        $headers = [
            'content-type' => 'application/json; charset=utf-8'
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4
        ];

        $options[CURLOPT_HTTPHEADER] = $headers;

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $resp = curl_exec($ch);
        $resp = json_decode($resp, true);
        curl_close($ch);

        if($resp['status']=='OK'){
            $lat = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
            $lng = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
            $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
            if($lat && $lng) {
                return response()->json([
                    'status' => 'OK',
                    'lat' => $lat,
                    'lng' => $lng,
                    'address' => $formatted_address
                ], 200);
            }
        }

        return response()->json([], 204);
    }

    public function deleteFile(Request $request)
    {
        $appid = $request->get('appid', 0);
        $app = Application::findOrFail($appid);

        $file = $request->get('file', '');

        Storage::disk('public')->delete('uploads/'.$app->form_id.'/'.$app->id, $file);

        return response()->json([
            'status' => 'OK'
        ], 200);
    }

}
