@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="row justify-content-center pt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Overview') }}</div>
    
                    <div class="card-body">
                        <ul>
                            <li>{{ sprintf(__('%d users.'), $overview->users_count) }}</li>
                            <li>{{ sprintf(__('%d subscriptions.'), $overview->subscriptions_count) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Activity')  }}</div>

                    <div class="card-body">
                        @forelse($activites as $activity)
                            <dt class="float-start">{{ $activity->created_at->toDateTimeString() }}</dt>
                            <dd style="margin-left: 160px;">{{ $activity->details }}</dd>
                        @empty
                            {{ __('No activites.') }}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
