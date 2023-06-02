@extends('layouts.app')

@section('content')
<div class="wrap container-fluid d-flex flex-column flex-grow-1 h-100">
    <div>
        <h1 class="h1-inline">
            <a href="{{ route_query('albums.index') }}">{{ __('Album') }}</a> / {{ $album->title }}
        </h1>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#album-photos-add">{{ __('Add Photo') }}</button>
    </div>
    @livewire('page-index', ['album' => $album])
</div>
@endsection