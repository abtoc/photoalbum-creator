<?php

namespace App\Http\Controllers;

use App\Jobs\MakeAlbumJob;
use App\Models\Album;
use App\UseCases\Albums\DestroyAction;
use App\UseCases\Albums\StoreAction;
use App\UseCases\Albums\UpdateAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Album::class, 'album');
    }

    public function index()
    {
        $albums = Auth::user()->albums()
            ->sortable(['updated_at' => 'desc'])
            ->paginate(20);
        return view('albums.index', ['albums' => $albums]);
    }

    public function create()
    {
        return view('albums.create', ['user' => Auth::user()]);
    }

    public function store(Request $request, StoreAction $action)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'cover' => ['required', 'file', 'mimetypes:image/jpeg', 'max:1024'],
        ]);
        $action($request);
        return to_route_query('albums.index');
    }

    public function edit(Album $album)
    {
        return view('albums.edit', ['album' => $album]);
    }

    public function update(Request $request, Album $album, UpdateAction $action)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'cover' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024'],
        ]);
        $action($request, $album);
        return to_route_query('albums.index');
    }

    public function destroy(Album $album, DestroyAction $action)
    {
        $action($album);
        return to_route_query('albums.index');
    }

    public function cover(Request $request, Album $album)
    {
        $this->authorize('view', $album);
        $path = sprintf('/%s/albums/%08d/cover.jpg', Auth::user()->email, $album->id);
        $type = Storage::disk('s3')->mimeType($path);
        $size = Storage::disk('s3')->size($path);

        return response()->stream(function() use($path){
            echo Storage::disk('s3')->get($path);
        }, 200, [
            'Content-type' => $type,
            'Content-length' => $size,
        ]);
    }

    public function make(Album $album)
    {
        $this->authorize('update', $album);
        Storage::disk('s3')->delete($album->getPath());
        MakeAlbumJob::dispatch($album);
        return to_route_query('albums.index');
    }

    public function download(Album $album)
    {
        $this->authorize('view', $album);
        return Storage::disk('s3')->download($album->getPath(), sprintf('%08d', $album->id).'.epub');
    }
}

