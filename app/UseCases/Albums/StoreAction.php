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
                sprintf('/%s/albums/%08d', Auth::user()->email, $album->id),
                'cover.jpg', 's3'
            );
        });
    }
}
