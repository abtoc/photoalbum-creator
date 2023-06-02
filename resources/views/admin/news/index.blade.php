@extends('layouts.admin')

@section('content')
<div class="wrap container">
    <div>
        <h1 class="h1-inline">{{ __('Notice') }}</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-outline-primary btn-sm d-inline mb-2">{{ __('Create New') }}</a>
    </div>
    <hr>
    <form action="{{ route('admin.news.index') }}" method="GET" class="row g-1">
        <label for="search-status" class="col-auto col-form-label text-md-end m-0">{{ __('Status') }}</label>
        <div class="col-auto">
            <select name="status" id="status" class="form-select form-select-sm">
                <option value="" @selected(is_null(request()->query('status')))>{{ __('All') }}</option>
                @foreach(App\Enums\News\Status::cases() as $status)
                    <option value="{{ $status->value }}" @selected(!is_null(request()->query('status')) && request()->query('status') == $status->value)>{{ $status->string() }}</option>
                @endforeach
            </select>
        </div>
        <label for="search-title" class="col-auto col-form-label text-md-end m-0">{{ __('Title') }}</label>
        <div class="col-auto">
            <input type="text" name="title" id="search-title" class="form-control form-control-sm" value="{{ request()->query('title') }}">
        </div>
        <div class="col-auto">
            <input type="submit" class="btn btn-outline-primary btn-sm" value="{{ __('Search') }}">
        </div>
    </form>
    <table id="news-index" class="table table-striped">
        <thead>
            <tr>
                <th class="column-status">{{ __('Status') }}</th>
                <th class="column-title">@sortablelink('title', __('Title'))</th>
                <th class="column-message">{{ __('Message') }}</th>
                <th class="column-updated">@sortablelink('updated_at', __('Updated'))</th>
                <th class="column-command"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($news_list as $news)
                <tr>
                    <td>{{ $news->status->string() }}</td>
                    <td>
                        <a href="{{ route_query('admin.news.view', ['news' => $news])}}">{{ $news->title }}</a>
                    </td>
                    <td class="text-truncate">{{ remove_markdown($news->message) }}</td>
                    <td>{{ $news->updated_at->toDateString() }}</td>
                    <td class="text-end">
                        <a href="{{ route_query('admin.news.edit', ['news' => $news]) }}" class="link-dark text-decoration-none">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="{{ route_query('admin.news.destroy', ['news' => $news]) }}" class="link-dark text-decoration-none" onclick="event.preventDefault(); document.getElementById('news-destroy-{{ $news->id }}').submit()">
                            <i class="bi bi-trash"></i>
                        </a>
                        <form action="{{ route_query('admin.news.destroy', ['news' => $news])}}" id="news-destroy-{{ $news->id }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $news_list->appends(request()->query())->links() }}
</div>
@endsection