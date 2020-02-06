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
            $filename = $request->file->store('uploads/'.$formId.'/'.$appid.'/', 'public');

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

        if ($app->to_be_approved == 0) {
            $app->createEntry();
            $app->adminSubmitEmail();
            $app->userSubmitEmail();
        } else {
            $app->managersSubmitEmail();
        }

        return response()->json([
            'status' => 'OK'
        ], 200);
    }

}
