<?php

namespace App\Http\Controllers;

use App\Enums\Album\Status;
use App\Jobs\MakeAlbumJob;
use App\Models\Album;
use App\UseCases\Albums\ForceDestroyAction;
use App\UseCases\Albums\DestroyAction;
use App\UseCases\Albums\RestoreAction;
use App\UseCases\Albums\StoreAction;
use App\UseCases\Albums\UpdateAction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Album::class, 'album');
    }

    public function index(Request $request)
    {
        $query = Auth::user()->albums()
            ->when($request->query('status') == (string)Status::TRASHED->value, function($q){
                return $q->onlyTrashed();
            })
            ->when(!is_null($request->query('status')), function($q) use($request){
                return $q->where('status', $request->query('status'));
            })
            ->when($request->query('title'), function($q) use($request){
                return $q->where('title', 'like', '%'.$request->query('title').'%');
            })
            ->sortable(['updated_at' => 'desc']);
        $albums = $query->paginate(20);
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

    public function forceDestroy($album, ForceDestroyAction $action)
    {
        $album = Auth::user()->albums()->onlyTrashed()->where('id', $album)->firstOrFail();
        $this->authorize('forceDelete', $album);
        $action($album);
        return to_route_query('albums.index');
    }

    public function restore($album, RestoreAction $action)
    {
        $album = Auth::user()->albums()->onlyTrashed()->where('id', $album)->firstOrFail();
        $this->authorize('restore', $album);
        $action($album);
        return to_route_query('albums.index');
    }

    public function cover(Request $request, Album $album)
    {
        $this->authorize('view', $album);
        $path = $album->getCoverPath();
        $type = Storage::disk('s3')->mimeType($path);
        $size = Storage::disk('s3')->size($path);
        $modified = $album->updated_at->toRfc7231String();
        $expires = $album->updated_at->addDays(7)->toRfc7231String();
        $stream = Storage::disk('s3')->readStream($path);
        $since = $request->header('If-Modified-Since');

        if($since){
            $since = new Carbon($since);
            if($since->gte($album->updated_at)){
                return response('', 304)
                    ->header('Content-Type', $type);
            }
        }

        return response()->stream(function() use($stream){
            fpassthru($stream);
        }, 200, [
            'Content-type' => $type,
            'Content-length' => $size,
            'Last-Modified' => $modified,
            'Expires' => $expires,
            'Cache-Control' => 'public',
        ]);
    }

    public function make(Album $album)
    {
        $this->authorize('update', $album);
        DB::transaction(function() use($album){
            Storage::disk('s3')->delete($album->getEpubPath());
            MakeAlbumJob::dispatch($album);
            $album->status = Status::PUBLISHING;
            $album->save();
        });
        return to_route_query('albums.index');
    }

    public function download(Album $album)
    {
        $this->authorize('view', $album);
        return Storage::disk('s3')->download($album->getEpubPath());
    }
}

