<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Form;
use App\FormEmail;
use App\Group;


class FormController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', false);
		$trash = $request->input('trash', false);
		$forms = Form::search($search, $trash);
        return view('admin.form.index', [
			'forms' => $forms->paginate(15),
			'total_records' => $forms->count(),
			'trash' => $trash,
			'search' => $search
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
            'groups' => Group::all()
        ]);
    }

    public function update(Request $request, Form $form)
    {
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
}
