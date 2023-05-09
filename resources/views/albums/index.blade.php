@extends('layouts.app')

@section('content')
<div class="wrap container-fluid">
    <h1 class="h1-inline">{{ __('Album') }}</h1><a href="{{ route('albums.create') }}" class="btn btn-outline-primary btn-sm">{{ __('Create New') }}</a>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Author') }}</th>
                <th>{{ __('Publisher') }}</th>
                <th class="text-center">{{ __('Pages') }}</th>
                <th>{{ __('Updated') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>{{ $album->id }}</td>
                    <td>{{ $album->title }}</td>
                    <td>{{ $album->author }}</td>
                    <td>{{ $album->publisher }}</td>
                    <td class="text-center">
                        {{ $album->pages()->count() }}
                    </td>
                    <td>{{ $album->updated_at->toDateTimeString() }}</td>
                    <td class="text-end">
                        <a href="{{ route('pages.index', ['album' => $album]) }}" class="link-dark text-decoration-none">
                            <i class="bi bi-images"></i>
                        </a>
                        <a href="{{ route('albums.edit', ['album' => $album]) }}" class="link-dark text-decoration-none">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="{{ route('albums.destroy', ['album' => $album]) }}" class="link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('albums-destroy-{{$album->id}}').submit()">
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
</div>
@endsection
