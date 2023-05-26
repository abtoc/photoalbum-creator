<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\UseCases\News\DestroyAction;
use App\UseCases\News\StoreAction;
use App\UseCases\News\UpdateAction;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query()
                    ->when(!is_null($request->query('status')), function($q) use($request){
                        return $q->where('status', $request->query('status'));
                    })
                    ->when($request->query('title'), function($q) use($request){
                        return $q->where('title', 'like', '%'.$request->query('title').'%');
                    })
                    ->sortable(['updated_at' => 'desc']);
        $news_list = $query->paginate(10);
        return view('admin.news.index', ['news_list' => $news_list]);
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request, StoreAction $action)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);
        $news = $action($request);
        if($request->has('preview')){
            return to_route_query('admin.news.view', ['news' => $news]);
        }
        return to_route_query('admin.news.index');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(Request $request, News $news, UpdateAction $action)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);
        $action($request, $news);
        if($request->has('preview')){
            return to_route_query('admin.news.view', ['news' => $news]);
        }
        return to_route_query('admin.news.index');
    }   

    public function show(News $news)
    { 
        return view('admin.news.view', ['news' => $news]);
    }

    public function destroy(News $news, DestroyAction $action)
    {
        $action($news);
        return to_route_query('admin.news.index');
    }
}
