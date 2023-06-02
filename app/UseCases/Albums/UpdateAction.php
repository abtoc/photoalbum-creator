<?php 

namespace App\UseCases\Albums;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    public function __invoke(Request $request, Album $album)
    {
        DB::transaction(function() use($request, $album){
            $album->fill($request->all());
            $album->save();

            $file = $request->file('cover');
            if($file != null){
                $file->storeAs(
                    $album->getDirectory(),
                    'cover.jpg', 's3'
                );
            }
        });
    }
}
