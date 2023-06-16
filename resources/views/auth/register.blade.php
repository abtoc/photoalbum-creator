@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tos" class="col-md-4 col-form-label text-md-end">{{ __('Terms of service') }}</label>
                            <div class="col-md-8">
                                <div class="markdown-body form-control mb-3" style="height:300px; overflow-y: auto; font-size: 80%">
                                    {{ markdown($tos) }}
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="tos" name="tos" class="form-check-input @error('tos') is-invalid @enderror">
                                    <label for="tos" class="form-check-label">
                                        {{ __('I agree to the Terms of Service') }}
                                    </label>
                                </div>
                                @error('tos')
                                    <span class="invalid-feedback d-inline" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            {!! no_captcha()->input() !!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{!! no_captcha()->script() !!}
{!! no_captcha()->getApiScript() !!}
<script>
    document.querySelector('#submitButton').addEventListener('click', (event) => {
        event.preventDefault();
        grecaptcha.ready(function(){
            grecaptcha.execute('{{config('no-captcha.sitekey')}}', {action: 'login'}).then(function(token) {
                document.querySelector('#g-recaptcha-response').value = token;
                document.querySelector('form').submit();
            });
        });
    });
</script>
@endpush
