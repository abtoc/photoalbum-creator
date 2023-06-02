@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Notice') }}</div>
                <div class="card-body">
                    <dl>
                        @forelse($news_list as $news)
                            <dt class="float-start">{{ $news->updated_at->toDateString() }}</dt>
                            <dd style="margin-left: 100px;"><a href="{{ route('news.view', ['news' => $news]) }}">{{ $news->title }}</a></dd>
                        @empty
                            {{ __('No notices.') }}
                        @endforelse
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Overview') }}</div>

                <div class="card-body">
                    <ul>
                        <li>
                            <a href="{{ route('payments.index') }}">
                                @if($overview->subcribed){{ __('Subscription contract in progress.') }}@else{{ __('Free plan.') }}@endif
                            </a>
                        </li>
                        <li>{{ sprintf(__('%d photos.'), $overview->photo_count) }}</li>
                        <li>{{ sprintf(__('%d albums.'), $overview->album_count) }}</li>
                        <li>{{ sprintf(__('%s out of %s use.'), byte_to_unit($overview->capacity), byte_to_unit($overview->used_capacity)) }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Activity') }}</div>
    
                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
