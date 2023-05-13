@extends('layouts.app')

@section('content')
<div class="wrap container-fluid">
    <h1 class="h1-inline">{{ __('Album') }}</h1><a href="{{ route_query('albums.create') }}" class="btn btn-outline-primary btn-sm">{{ __('Create New') }}</a>
    <hr>
    <table class="table table-striped fixed">
        <thead>
            <tr>
                <th class="column-title">@sortablelink('title', __('Title'))</th>
                <th class="column-author">{{ __('Author') }}</th>
                <th class="column-publisher">{{ __('Publisher') }}</th>
                <th class="column-pages text-center">{{ __('Pages') }}</th>
                <th class="column-uploaded">@sortablelink('updated_at', __('Updated'))</th>
                <th class="column-id">{{ __('ID') }}</th>
                <th class="column-command"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>
                        @livewire('album-title', ['album' => $album], key($album->id))
                    </td>
                    <td>{{ $album->author }}</td>
                    <td>{{ $album->publisher }}</td>
                    <td class="text-center">
                        {{ $album->pages()->count() }}
                    </td>
                    <td>{{ $album->updated_at->toDateTimeString() }}</td>
                    <td>{{ $album->id }}</td>
                    <td class="text-end">
                        @if($album->photo_count > 0)
                            <a href="{{ route_query('albums.make', ['album' => $album]) }}" class="link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('albums-make-{{$album->id}}').submit()">
                                <i class="bi bi-book"></i>
                            </a>
                            <form id="albums-make-{{$album->id}}" method="POST" class="d-none" action="{{ route('albums.make', ['album' => $album]) }}">
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
                        <form id="albums-destroy-{{$album->id}}" method="POST" class="d-none" action="{{ route('albums.destroy', ['album' => $album]) }}">
                            @csrf
                            @method('DELETE');
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $albums->appends(request()->query())->links() }}
</div>
@endsection
