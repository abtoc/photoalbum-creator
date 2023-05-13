<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\UseCases\Photos\UploadAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Photo::class, 'photo');
    }

    public function index()
    {
        return view('photos.index');
    }

    public function upload(Request $request, UploadAction $action){
        $action($request);
        return response()->json([
        ], 201);
    }

    public function view(Request $request, Photo $photo)
    {
        $this->authorize('view', $photo);
        $path = $photo->getPath($request->query('size', ''));
        if(Storage::disk('s3')->missing($path)){
            abort(404);
        }
        $type = Storage::disk('s3')->mimeType($path);
        $size = Storage::disk('s3')->size($path);
        $modified = $photo->updated_at->toRfc7231String();
        $stream = Storage::disk('s3')->readStream($path);

        return response()->stream(function() use($stream){
            fpassthru($stream);
        }, 200, [
            'Content-type' => $type,
            'Content-length' => $size,
            'Last-Modified' => $modified,
        ]);
    }

    public function download(Request $request, Photo $photo)
    {
        $path = $photo->getPath($request->query('size', ''));
        return Storage::disk('s3')->download($path, $photo->name.'.jpg');
    }
}
