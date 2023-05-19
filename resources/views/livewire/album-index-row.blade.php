<tr wire:poll.30s>
    <td>{{ $album->status->string() }}</td>
    <td>{{ $album->title }}</td>
    <td>{{ $album->author }}</td>
    <td>{{ $album->publisher }}</td>
    <td class="text-center">
        {{ $album->pages()->count() }}
    </td>
    <td>{{ $album->updated_at->toDateTimeString() }}</td>
    <td>{{ $album->id }}</td>
    <td class="text-end">
        @if(is_null($album->deleted_at))
            @if($album->status === App\Enums\Album\Status::PUBLISHED)
                <a href="{{ route('albums.download', ['album' => $album]) }}" class="link-dark text-decoration-none"><i class="bi bi-download"></i></a>
            @endif
            @if($album->photo_count > 0 && !Auth::user()->checkCapacityOver())
                <a href="{{ route_query('albums.make', ['album' => $album]) }}" class="link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('albums-make-{{$album->id}}').submit()">
                    <i class="bi bi-book"></i>
                </a>
                <form id="albums-make-{{$album->id}}" method="POST" class="d-none" action="{{ route_query('albums.make', ['album' => $album]) }}">
                    @csrf
                </form>
            @endif
            <a href="{{ route_query('pages.index', ['album' => $album]) }}" class="link-dark text-decoration-none">
                <i class="bi bi-images"></i>
            </a>
            <a href="{{ route_query('albums.edit', ['album' => $album]) }}" class="link-dark text-decoration-none">
                <i class="bi bi-pencil"></i>
            </a>
            <a href="{{ route_query('albums.destroy', ['album' => $album]) }}" class="link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('albums-destroy-{{$album->id}}').submit()">
                <i class="bi bi-trash"></i>
            </a>
            <form id="albums-destroy-{{$album->id}}" method="POST" class="d-none" action="{{ route_query('albums.destroy', ['album' => $album]) }}">
                @csrf
                @method('DELETE');
            </form>
        @else
            <a href="{{ route_query('albums.restore', ['album' => $album]) }}" class="link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('albums-restore-{{$album->id}}').submit()">
                <i class="bi bi-reply"></i>
            </a>
            <form id="albums-restore-{{$album->id}}" method="POST" class="d-none" action="{{ route_query('albums.restore', ['album' => $album]) }}">
                @csrf
                @method('PUT');
            </form>
            <a href="{{ route_query('albums.force', ['album' => $album]) }}" class="link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('albums-force-{{$album->id}}').submit()">
                <i class="bi bi-x-lg"></i>
            </a>
            <form id="albums-force-{{$album->id}}" method="POST" class="d-none" action="{{ route_query('albums.force', ['album' => $album]) }}">
                @csrf
                @method('DELETE');
            </form>
        @endif
    </td>
</tr>
