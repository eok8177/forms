<?php

/**
* Description:
* Controller (based on MVC architecture) for the management of news articles
* All the methods are available only for the admin
*
* Copyright: Rural Workforce Agency, Victoria (RWAV)
* Contact email: rwavsupport@rwav.com.au
*
* Authors:
* Sergey Markov | SergeyM@rwav.com.au
* 
* List of methods:
* - index(Request $request) | show the list of all news
* - create()
* - store(Request $request, News $news)
* - edit(News $news)
* - update(Request $request, News $news)
* - destroy(News $news)
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    /**
    * Description:
    * show the list of all news
    *
    * List of parameters:
    * - $request : Request
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/news
    */
    public function index(Request $request)
    {
        $search = $request->input('search', false);

        $news = News::orderBy('order','asc');

        if ($search) {
            $news->where('title','LIKE', '%'.$search.'%')
                ->orWhere('preview','LIKE', '%'.$search.'%');
        }

        return view('admin.news.index', [
            'news' => $news->get(),
            'search' => $search
        ]);
    }


    /**
    * Description:
    * Create new news page
    *
    * List of parameters:
    * - none
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - <baseUrl>/admin/news/create
    */
    public function create()
    {
        return view('admin.news.create', ['news' => new News]);
    }


    /**
    * Description:
    * Store just created news page (POST method)
    *
    * List of parameters:
    * -  $request : Request
    * - $news : News
    *
    * Return:
    * view content, redirects to the list of News
    *
    * Examples of usage:
    * - create new News page, prefill it and click "Save"
    */
    public function store(Request $request, News $news)
    {
        $news = $news->create($request->all());

        return redirect()->route('admin.news.index')->with('success', 'News created');
    }


    /**
    * Description:
    * Edit News page
    *
    * List of parameters:
    * - $news : News
    *
    * Return:
    * view cotent
    *
    * Examples of usage:
    * - <baseUrl>/admin/news/2/edit
    */
    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }


    /**
    * Description:
    * Update News page (PUT method)
    *
    * List of parameters:
    * - $request : Request
    * - $news : News
    *
    * Return:
    * view content
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/news/2/edit and click "Save"
    */
    public function update(Request $request, News $news)
    {
        $news->update($request->all());

        return redirect()->route('admin.news.edit', ['news' => $news->id])->with('success', 'News updated');
    }


    /**
    * Description:
    * Delete news page (DELETE method)
    *
    * List of parameters:
    * - $news : News
    *
    * Return:
    * Response: {status: 'success'}
    *
    * Examples of usage:
    * - Go to <baseUrl>/admin/news and click to trash icon at any item in the list
    */
    public function destroy(News $news)
    {
        $news->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
