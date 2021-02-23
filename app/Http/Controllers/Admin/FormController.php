<?php

/**
* Description:
* Controller (based on MVC architecture) for the management of form definitions
* All the methods are available only for the admin
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index(Request $request) | show the list of forms
* - create() | Create new form
* - store(Request $request, Form $form) | Store just created new form (POST method)
* - show(Form $form) | Preview the form 
* - edit(Form $form) | Edit the form definition
* - setting(Form $form) | View form's settings
* - update(Request $request, Form $form) | Update form definitions (PUT method)
* - email(Form $form) | View email notification settings for the form
* - emailStore(Request $request, Form $form) | Update email notification settings for the form (PUT method) 
* - destroy(Form $form) | Delete form definition (DELETE method)
* - copy(Form $form) | Duplicate the form definitions
* - alias(Request $request, Form $form) | admin form setting: update alias
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Form;
use App\FormEmail;
use App\Group;
use App\FormType;
use App\Setting;
use App\ApiCall;


class FormController extends Controller
{

    /**
    * Description:
    * show the list of forms
    *
    * List of parameters:
    * -  $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form
    */
    public function index(Request $request)
    {
        $search = $request->input('search', false);
        $trash = $request->input('trash', 0);
        $form_type_id = $request->input('form_type_id', 0);
        $forms = Form::search($search, $trash)->orderBy('id', 'desc');

        if ($form_type_id > 0) {
            $forms->where('form_type_id', $form_type_id);
        }

        return view('admin.form.index', [
			'forms' => $forms->paginate(15),
			'trash' => $trash,
			'search' => $search,
            'form_types' => FormType::pluck('name', 'id'),
            'form_type_id' => $form_type_id
			]);
    }


    /**
    * Description:
    * Create new form
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form/create
    */
    public function create()
    {
        return view('admin.form.create', ['form' => new Form]);
    }


    /**
    * Description:
    * Store just created new form (POST method)
    *
    * List of parameters:
    * - $request : Request
    * - $form : Form
    *
    * Return:
    * view content, redirects to detailed form definition
    *
    * Examples of usage:
    * - create new form, prefill it and click "Save"
    */
    public function store(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required',
            'name' => 'required|unique:forms',
        ]);

        $form = $form->create($request->all());

        $form->login_only = 1;
        $form->save();

        return redirect()->route('admin.form.edit', ['form' => $form->id])->with('success', 'Form created');
    }


    /**
    * Description:
    * Preview the form 
    *
    * List of parameters:
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - go to the list of forms <baseUrl>/admin/form, then click to the eye icon from the Actions column
    */
    public function show(Form $form)
    {
        return redirect()->route('admin.form.index');
    }


    /**
    * Description:
    * Edit the form definition
    *
    * List of parameters:
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form/4/edit
    */
    public function edit(Form $form)
    {
        return view('admin.form.edit', [
            'form' => $form,
            'settings' => Setting::pluck('value', 'key')
        ]);
    }


    /**
    * Description:
    * View form's settings
    *
    * List of parameters:
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form/4/setting
    */
    public function setting(Form $form)
    {
        return view('admin.form.setting', [
            'form' => $form,
            'groups' => Group::all(),
            'form_types' => FormType::pluck('name', 'id')
        ]);
    }


    /**
    * Description:
    * Update form definitions (PUT method)
    *
    * List of parameters:
    * - $request : Request
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/form/4/edit and click "Save"
    */
    public function update(Request $request, Form $form)
    {
        $form->slug = null;
        $form->update($request->except('groups'));

        $form->groups()->detach();
        // Groups attach
        if ($request->has('groups')) {
            $form->groups()->attach($request->input('groups'));
        }

        return redirect()->route('admin.form.setting', ['form' => $form->id])->with('success', 'Form settings updated');
    }


    /**
    * Description:
    * View email notification settings for the form
    *
    * List of parameters:
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/form/4/email
    */
    public function email(Form $form)
    {
        $types = FormEmail::TYPES;

        foreach ($types as $type => $name) {
            $form_emails[$type] = $form->emails()->firstOrCreate(['type' => $type]);
        }

        return view('admin.form.email', [
            'form' => Form::where('id',$form->id)->first(),
            'types' => $types,
            'form_emails' => $form_emails
        ]);
    }


    /**
    * Description:
    * Update email notification settings for the form (PUT method) 
    *
    * List of parameters:
    * - $request : Request
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/form/4/email and click "Save"
    */
    public function emailStore(Request $request, Form $form)
    {
        foreach ($request->except(['_token', '_method', 'login_only']) as $key => $item) {
            $form->email($key)->update($item);
        }

        $form->login_only = $request->get('login_only',0);
        $form->save();

        return redirect()->route('admin.form.email', ['form' => $form->id])->with('success', 'Form Emails updated');
    }


    /**
    * Description:
    * Delete form definition page (DELETE method)
    *
    * List of parameters:
    * - $form : Form
    *
    * Return:
    * Response: {status: 'success'}
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/form and click to trash icon at any form in the list
    */
    public function destroy(Form $form)
    {
        $api = new ApiCall;
        $formData = (object)[
            'portal_form_id' => $form->id, 
            'portal_form_name' => $form->name
        ];
        $data = $api->deleteForm($formData);

        $form->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }


    /**
    * Description:
    * Duplicate the form definitions
    *
    * List of parameters:
    * - $form : Form
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - 
    */
    public function copy(Form $form)
    {
        $groups = $form->groups->pluck('id');

        $newForm = $form->replicate();
        $newForm->name .= ' Copy';
        $newForm->draft = 1;
        $newForm->save();
        // Groups attach
        if ($groups) {
            $newForm->groups()->attach($groups);
        }

        return redirect()->route('admin.form.index')->with('success', 'Form duplicated');
    }


    /**
    * Description:
    * admin form setting: update alias
    *
    * List of parameters:
    * - $request : Request
    * - $form : Form
    *
    * Return:
    * 
    *
    * Examples of usage:
    * resources/views/admin/form/setting.blade.php
    */
    public function alias(Request $request, Form $form)
    {
        $form->updateAlias($request->except(['_method','_token']));
        return redirect()->route('admin.form.setting', ['form' => $form->id])->with('success', 'Form alias updated');
    }
}
