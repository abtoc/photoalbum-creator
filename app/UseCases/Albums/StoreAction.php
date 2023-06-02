<?php 

namespace App\UseCases\Albums;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreAction
{
    public function __invoke(Request $request)
    {
        DB::transaction(function() use($request){
            $album = Auth::user()->albums()->create($request->all());

            $file = $request->file('cover');
            $file->storeAs(
                $album->getDirectory(),
                'cover.jpg', 's3'
            );
        });
    }
}
