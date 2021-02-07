<?php

/**
* Description:
* Controller (based on MVC architecture) for the management of form types
* All the methods are available only for the admin
* 
* List of methods:
* - index() | show the list of form types
* - create() | Create new form type
* - store(Request $request, FormType $form_type) | Store just created new form type (POST method)
* - edit(FormType $form_type) | Edit form type
* - update(Request $request, FormType $form_type) | Update form type (PUT method)
* - destroy(FormType $form_type) | Delete form type (DELETE method)
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FormType;
use App\Setting;

class FormTypeController extends Controller
{

    /**
    * Description:
    * show the list of form types
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form-types
    */
    public function index()
    {
        return view('admin.formtype.index', ['form_types' => FormType::all()]);
    }


    /**
    * Description:
    * Create new form type
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form-type/create
    */
    public function create()
    {
        return view('admin.formtype.create', [
            'form_type' => new FormType,
            'colors' => Setting::colors()
        ]);
    }


    /**
    * Description:
    * Store just created new form type (POST method)
    *
    * List of parameters:
    * - $request : Request
    * - $form_type : FormType
    *
    * Return:
    * view content, redirects to the list of form types
    *
    * Examples of usage:
    * - create new Form Type, prefill it and click "Save"
    */
    public function store(Request $request, FormType $form_type)
    {
        $form_type = $form_type->create($request->all());

        return redirect()->route('admin.form-type.index')->with('success', 'Form Type created');
    }


    /**
    * Description:
    * Edit form type
    *
    * List of parameters:
    * - $form_type : FormType
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form-type/2/edit
    */
    public function edit(FormType $form_type)
    {
        $colors = Setting::colors();
        if (!in_array($form_type->color, $colors)) {
            array_push($colors, $form_type->color);
        }

        return view('admin.formtype.edit', [
            'form_type' => $form_type,
            'colors' => $colors
        ]);
    }


    /**
    * Description:
    * Update form type (PUT method)
    *
    * List of parameters:
    * - $request : Request
    * - $form_type : FormType
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/form-type/2/edit and click "Save"
    */
    public function update(Request $request, FormType $form_type)
    {
        $form_type->update($request->all());

        return redirect()->route('admin.form-type.index')->with('success', 'Form Type updated');
    }


    /**
    * Description:
    * Delete form type (DELETE method)
    *
    * List of parameters:
    * - $form_type : FormType
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/form-type and click to trash icon at any item in the list
    */
    public function destroy(FormType $form_type)
    {
        $form_type->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
