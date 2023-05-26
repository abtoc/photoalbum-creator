<?php

namespace App\UseCases\News;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    public function __invoke(Request $request, News $news)
    {
        DB::transaction(function() use($request, $news){
            $news->fill($request->all());
            $news->save();
        });
    }
}