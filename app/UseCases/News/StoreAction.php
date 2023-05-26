<?php

namespace App\UseCases\News;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreAction
{
    public function __invoke(Request $request)
    {
        $news = null;
        DB::transaction(function() use($request, &$news){
            $news = News::create($request->all());
        });
        return $news;
    }
}