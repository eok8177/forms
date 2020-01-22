<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Form;
use App\FormEmail;
use App\Group;
use App\FormType;


class FormController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', false);
		$trash = $request->input('trash', 0);
        $form_type_id = $request->input('form_type_id', 0);
		$forms = Form::search($search, $trash);

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

    public function create()
    {
        return view('admin.form.create', ['form' => new Form]);
    }

    public function store(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $form = $form->create($request->all());

        return redirect()->route('admin.form.index')->with('success', 'Form created');
    }

    public function show(Form $form)
    {
        return redirect()->route('admin.form.index');
    }

    public function edit(Form $form)
    {
        return view('admin.form.edit', ['form' => $form]);
    }

    public function setting(Form $form)
    {
        return view('admin.form.setting', [
            'form' => $form,
			'groups' => Group::all(),
			'form_types' => FormType::pluck('name', 'id')
        ]);
    }

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

    public function email(Form $form)
    {
        if(empty($form->email))
            $form->email()->save(new FormEmail);

        return view('admin.form.email', [
            'form' => Form::where('id',$form->id)->with('email')->first()
        ]);
    }

    public function emailStore(Request $request, Form $form)
    {
        $form->email->update($request->all());

        return view('admin.form.email', ['form' => $form]);
    }

    public function destroy(Form $form)
    {
        $form->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function copy(Form $form)
    {
        $newForm = $form->replicate();
        $newForm->name .= ' Copy';
        $newForm->draft = 1;
        $newForm->save();

        return redirect()->route('admin.form.index')->with('success', 'Form duplicated');
    }
}
