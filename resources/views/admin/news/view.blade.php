@extends((request()->routeIs('admin.*')) ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="py-4 container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>{{ $news->title }}</div>
                        <div>
                            {{ $news->updated_at->toDateTimeString() }}
                            @if(request()->routeIs('admin.*'))
                                <a href="{{ route_query('admin.news.edit', ['news' => $news]) }}" class="link-dark text-decoration-none">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endif
                        </div>                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="markdown-body">
                        {{ markdown($news->message) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection