<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Form;


class FormController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', false);
        $trash = $request->input('trash', false);
        return view('admin.form.index', ['forms' => Form::search($search, $trash)->paginate(15)]);
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

    public function update(Request $request, Form $form)
    {
        $form->update($request->all());

        return redirect()->route('admin.form.edit', ['form' => $form->id])->with('success', 'Form updated');
    }

    public function destroy(Form $form)
    {
        $form->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
