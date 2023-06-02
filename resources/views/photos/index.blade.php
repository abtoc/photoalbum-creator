@extends('layouts.app')

@section('content')
<div class="wrap container-fluid d-flex flex-column flex-grow-1 h-100">
    <div>
        <h1 class="h1-inline">{{ __('Photo Library') }}</h1>
        <button id="uppy-select-files" class="btn btn-outline-primary btn-sm">{{ __('Import') }}</button>
    </div>
    <div id="uppy-drop-area"></div>
    @livewire('photo-index')
</div>
@endsection