<?php 

namespace App\UseCases\Albums;

use App\Models\Album;
use Illuminate\Support\Facades\DB;

class DestroyAction
{
    public function __invoke(Album $album)
    {
        DB::transaction(function() use($album){
            $album->delete();
        });
    }
}
