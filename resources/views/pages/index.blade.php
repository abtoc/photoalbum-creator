@extends('layouts.app')

@section('content')
<div class="wrap container-fluid">
    <h1 class="h1-inline">{{ $album->title }}</h1><button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#album-photos-add">{{ __('Add Photo') }}</button>
    @livewire('page-index', ['album' => $album])
</div>
@endsection