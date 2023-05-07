@extends('layouts.app')

@section('content')
<div class="wrap container-fluid">
    <h1 class="h1-inline">{{ __('Photo Library') }}</h1><button id="uppy-select-files" class="btn btn-outline-primary btn-sm">{{ __('Import') }}</button>
    <div id="uppy-drop-area"></div>
    @livewire('photo-index')
</div>
@endsection