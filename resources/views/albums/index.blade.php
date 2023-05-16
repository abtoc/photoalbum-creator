@extends('layouts.app')

@section('content')
<div class="wrap container-fluid">
    <h1 class="h1-inline">{{ __('Album') }}</h1><a href="{{ route_query('albums.create') }}" class="btn btn-outline-primary btn-sm">{{ __('Create New') }}</a>
    <hr>
    <form action="{{ route('albums.index') }}" method="GET" class="row g-1">
        <label for="search-status" class="col-auto col-form-label text-md-end m-0">{{ __('Status') }}:</label>
        <div class="col-auto">
            <select name="status" id="search-status" class="form-select form-select-sm">
                <option value="" @selected(is_null(request()->query('status')))>{{ __('All') }}</option>
                @foreach(App\Enums\Album\Status::cases() as $status)
                    @if($status == App\Enums\Album\Status::PUBLISHING)
                        @continue
                    @endif
                    @if($status == App\Enums\Album\Status::ERROR)
                        @continue
                    @endif
                    <option value="{{ $status->value }}" @selected(!is_null(request()->query('status')) && $status->value == request()->query('status'))>{{ $status->string() }}</option>
                @endforeach
            </select>         
        </div>
        <label for="search-title" class="col-auto col-form-label text-md-end m-0">{{ __('Title') }}:</label>
        <div class="col-auto">
            <input id="search-title" name="title" type="input" class="form-control form-control-sm" value="{{ request()->query('title') }}">
        </div>
        <div class="col-auto">
            <input type="submit" class="btn btn-outline-primary btn-sm" value="{{ __('Search') }}">
        </div>
    </form>
    <table id="album-index" class="table table-striped fixed">
        <thead>
            <tr>
                <th class="column-status">{{ __('Status') }}</th>
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
                    <td>@livewire('album-status', ['album' => $album], key($album->id))</td>
                    <td> {{ $album->title }}</td>
                    <td>{{ $album->author }}</td>
                    <td>{{ $album->publisher }}</td>
                    <td class="text-center">
                        {{ $album->pages()->count() }}
                    </td>
                    <td>{{ $album->updated_at->toDateTimeString() }}</td>
                    <td>{{ $album->id }}</td>
                    <td class="text-end">
                        @if(is_null($album->deleted_at))
                            @livewire('album-download', ['album' => $album], key($album->id))
                            @if($album->photo_count > 0)
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
            @endforeach
        </tbody>
    </table>
    {{ $albums->appends(request()->query())->links() }}
</div>
@endsection
