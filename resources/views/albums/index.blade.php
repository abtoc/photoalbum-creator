@extends('layouts.app')

@section('content')
<div class="wrap container-fluid">
    <div>
        <h1 class="h1-inline">{{ __('Album') }}</h1>
        <a href="{{ route_query('albums.create') }}" class="btn btn-outline-primary btn-sm d-inline mb-2">{{ __('Create New') }}</a>
    </div>
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
                @livewire('album-index-row', ['album' => $album], key($album->id))
            @endforeach
        </tbody>
    </table>
    {{ $albums->appends(request()->query())->links() }}
</div>
@endsection
