<?php 

namespace App\UseCases\Albums;

use App\Models\Album;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __invoke(Album $album)
    {
        DB::transaction(function() use($album){
            $album->restore();
        });
    }
}
