@extends('layouts.admin')

@section('content')
<div class="py-4 container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{ route_query('admin.news.index') }}">{{ __('Notice') }}</a></div>
                <div class="card-body">
                    <form action="{{ route_query('admin.news.update', ['news' => $news]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-10">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $news->title) }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-md-2 col-form-label text-md-end">{{ __('Status') }}</label>

                            <div class="col-md-10">
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    @foreach(App\Enums\News\Status::cases() as $status)
                                        <option value="{{ $status->value }} @selected(!is_null(old('status', $news->status)) && $status->value === old('status'))">
                                            {{ $status->string() }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="message" class="col-md-2 col-form-label text-md-end">{{ __('Message') }}</label>

                            <div class="col-md-10">
                                <textarea name="message" id="message" cols="30" rows="20" class="form-control @error('title') is-invalid @enderror" required>{{ old('message', $news->message) }}</textarea>

                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                                <button type="submit" class="btn btn-primary" name="preview">
                                    {{ __('Preview') }}
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