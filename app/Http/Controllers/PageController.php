<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request, Album $album)
    {
        if($request->user()->cannot('view', $album)){
            abort(403);
        }
        return view('pages.index', ['album' => $album]);
    }
}
