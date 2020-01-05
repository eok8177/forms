<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Page;


class PageController extends Controller
{
	public function index()
	{
		return view('admin.page.index', ['pages' => Page::select('id','title')->paginate(15)]);
	}

	public function edit(Page $page)
    {
        return view('admin.page.edit', ['page' => $page]);
	}
	
    public function update(Request $request, Page $page)
    {
        $page->update($request->all());

        return redirect()->route('admin.page.edit', ['page' => $page])->with('success', 'Page updated');
    }

}