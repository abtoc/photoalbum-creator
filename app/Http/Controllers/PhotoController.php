<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\UseCases\Photos\UploadAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        return view('photos.index');
    }

    public function upload(Request $request, UploadAction $action){
        $action($request);
        return response()->json([
            'url' => ''
        ], 201);
    }

    public function view(Request $request, Photo $photo)
    {
        $path = $photo->getPath($request->query('size', ''));
        $type = Storage::disk('s3')->mimeType($path);
        $size = Storage::disk('s3')->size($path);

        return response()->stream(function() use($path){
            echo Storage::disk('s3')->get($path);
        }, 200, [
            'Content-type' => $type,
            'Content-length' => $size,
        ]);
    }

    public function download(Request $request, Photo $photo)
    {
        $path = $photo->getPath($request->query('size', ''));
        return Storage::disk('s3')->download($path, $photo->name.'.jpg');
    }
}
