<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumPhotoController extends Controller
{
    public function index(Request $request, Album $album)
    {
        if($request->user()->cannot('view', $album)){
            abort(403);
        }
        return view('album-photos.index', ['album' => $album]);
    }
}
