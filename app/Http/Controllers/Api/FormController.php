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

    public function entry(Request $request) {

        $entry_id = 1;
        $userid = $request->get('userid', 0);
        $formid = $request->get('formid');
        $data = $request->get('data');

        $form = Form::find($formid);

        $last = Entry::latest()->first();
        if ($last) {
            $entry_id = $last->entry_id + 1;
        }

        foreach ($data as $item) {
            $entry = new Entry;
            $entry->entry_id = $entry_id;
            $entry->form_id = $formid;
            $entry->name = $item['label'];
            $entry->value = $item['value'];
            $entry->field_id = $item['field_id'];
            $entry->user_id = $userid;
            $entry->save();
        }

        $app = Application::where('user_id', $userid)->where('form_id', $formid)->first();
        if ($app) {
            $app->sent = 1;
            $app->save();
        }

        return response()->json([
            'status' => 'OK',
            'entryid' => $entry_id,
            'redirect_url' => $form->redirect_url ? $form->redirect_url : '/success/'.$formid,
        ], 200);
    }

    public function upload(Request $request) {

        $userid = $request->get('userid', 0);
        $entryId = $request->get('entryId');
        $formId = $request->get('formId');
        if ($fieldName = $request->get('fieldName')) {
            $filename = $request->file->store('uploads/'.$formId.'/'.$entryId.'/', 'public');

            $entry = new Entry;
            $entry->entry_id = $entryId;
            $entry->form_id = $formId;
            $entry->name = $fieldName;
            $entry->value = '<a href="/'.$filename.'" target="_blank">Download</a>';
            $entry->user_id = $userid;
            $entry->save();

            return response()->json([
                'status' => 'OK',
            ], 200);
        }

        return response()->json([
            'status' => 'not found file',
        ], 400);
    }

    public function saveApp(Request $request) {
        $userid = $request->get('userid', 0);
        $formid = $request->get('formid');
        $data = $request->input('data', false);

        $app = Application::where('user_id', $userid)->where('form_id', $formid)->first();

        if (!$app) {
            $app = new Application;
        }

        $app->user_id = $userid;
        $app->form_id = $formid;
        $app->config = json_encode($data);
        $app->save();

        return response()->json([
            'status' => 'OK',
            'appid' => $app->id
        ], 200);
    }

}
