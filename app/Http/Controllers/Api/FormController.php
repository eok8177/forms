<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Form;
use App\Entry;


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
        $formid = $request->get('formid');
        $data = $request->get('data');

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
            $entry->save();
        }

        return response()->json([
            'status' => 'OK',
        ], 200);
    }

}
