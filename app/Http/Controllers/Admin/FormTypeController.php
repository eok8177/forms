<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FormType;

class FormTypeController extends Controller
{
    public function index()
    {
        return view('admin.formtype.index', ['form_types' => FormType::all()]);
    }

    public function create()
    {
        return view('admin.formtype.create', ['form_type' => new FormType]);
    }

    public function store(Request $request, FormType $form_type)
    {
        $form_type = $form_type->create($request->all());

        return redirect()->route('admin.form-type.index')->with('success', 'Form Type created');
    }

    public function edit(FormType $form_type)
    {
        return view('admin.formtype.edit', ['form_type' => $form_type]);
    }

    public function update(Request $request, FormType $form_type)
    {
        $form_type->update($request->all());

        return redirect()->route('admin.form-type.index')->with('success', 'Form Type updated');
    }

    public function destroy(FormType $form_type)
    {
        $form_type->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
