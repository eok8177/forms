<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
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

    public function create()
    {
        return view('admin.news.create', ['news' => new News]);
    }

    public function store(Request $request, News $news)
    {
        $news = $news->create($request->all());

        return redirect()->route('admin.news.index')->with('success', 'News created');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $news->update($request->all());

        return redirect()->route('admin.news.edit', ['news' => $news->id])->with('success', 'News updated');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
