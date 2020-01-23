<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', false);

        $faq = Faq::orderBy('order','asc');

        if ($search) {
            $faq->where('question','LIKE', '%'.$search.'%');
                // ->orWhere('answer','LIKE', '%'.$search.'%');
        }

        return view('admin.faq.index', [
            'faqs' => $faq->get(),
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('admin.faq.create', ['faq' => new Faq]);
    }

    public function store(Request $request, Faq $faq)
    {
        $faq = $faq->create($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ created');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', ['faq' => $faq]);
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($request->all());

        return redirect()->route('admin.faq.edit', ['faq' => $faq->id])->with('success', 'FAQ updated');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
