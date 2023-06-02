<?php

namespace App\UseCases\News;

use App\Models\News;
use Illuminate\Support\Facades\DB;

class DestroyAction
{
    public function __invoke(News $news)
    {
        DB::transaction(function() use($news){
            $news->delete();
        });
    }
}