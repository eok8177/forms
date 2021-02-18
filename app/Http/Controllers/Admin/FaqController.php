<?php

/**
* Description:
* Controller (based on MVC architecture) for the management of FAQs pages
* All the methods are available only for the admin
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index(Request $request) | show the list of FAQs
* - create() | Create new FAQ page
* - store(Request $request, Faq $faq) | Store just created new FAQ page (POST method)
* - edit(Faq $faq) | Edit FAQ page
* - update(Request $request, Faq $faq) | Update FAQ page (PUT method)
* - destroy(Faq $faq) | Delete FAQ page (DELETE method)
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    /**
    * Description:
    * show the list of FAQs
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/faq
    */
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


    /**
    * Description:
    * Create new FAQ page
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/faq/create
    */
    public function create()
    {
        return view('admin.faq.create', ['faq' => new Faq]);
    }


    /**
    * Description:
    * Store just created new FAQ page (POST method)
    *
    * List of parameters:
    * - $request : Request
    * - $faq : Faq
    *
    * Return:
    * view content, redirects to the list of FAQs
    *
    * Examples of usage:
    * - create new FAQ page, prefill it and click "Save"
    */
    public function store(Request $request, Faq $faq)
    {
        $faq = $faq->create($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ created');
    }


    /**
    * Description:
    * Edit FAQ page
    *
    * List of parameters:
    * - $faq : Faq
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/faq/4/edit
    */
    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', ['faq' => $faq]);
    }


    /**
    * Description:
    * Update FAQ page (PUT method)
    *
    * List of parameters:
    * - $request : Request
    * - $faq : Faq
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/faq/4/edit and click "Save"
    */
    public function update(Request $request, Faq $faq)
    {
        $faq->update($request->all());

        return redirect()->route('admin.faq.edit', ['faq' => $faq->id])->with('success', 'FAQ updated');
    }


    /**
    * Description:
    * Delete FAQ page (DELETE method)
    *
    * List of parameters:
    * - $faq : Faq
    *
    * Return:
    * Response: {status: 'success'}
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/faq and click to trash icon at any item in the list
    */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
