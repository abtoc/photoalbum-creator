@extends('layouts.app')

@section('content')
<div class="py-4 container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Setting') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('options.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="publisher" class="col-md-4 col-form-label text-md-end">{{ __('Publisher') }}</label>

                            <div class="col-md-6">
                                <input id="publisher" type="text" class="form-control @error('publisher') is-invalid @enderror" name="publisher" value="{{ old('publisher', $option->publisher) }}" autocomplete="publisher" autofocus>

                                @error('publisher')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lines-per-page" class="col-md-4 col-form-label text-md-end">{{ __('Number of lines to display on a page') }}</label>

                            <div class="col-md-6">
                                <input id="lines-per-page" type="text" class="form-control @error('lines_per_page') is-invalid @enderror" name="lines_per_page" value="{{ old('lines_per_page', $option->lines_per_page) }}" required autocomplete="lines_per_page" autofocus>

                                @error('lines_per_page')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="expire" class="col-md-4 col-form-label text-md-end">{{ __('Number of days to clear the trash') }}</label>

                            <div class="col-md-6">
                                <input id="expire" type="text" class="form-control @error('expire') is-invalid @enderror" name="expire" value="{{ old('expire', $option->expire) }}" required autocomplete="expire" autofocus>

                                @error('expire')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
