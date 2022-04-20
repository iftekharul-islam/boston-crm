@extends('layouts.app')

@section('content')
    <div class="login ">
        <div class="d-flex login-row login-space flex-wrap">
            <div class="left-side col-md-6 bg-light-black">
                <a href="/" class="back-btn">Back</a>
                <div class="login-box">
                    <div class="login-header fs-20 text-light-black mgb-48 fw-bold">{{ __('Login') }}</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="group mgb-40">
                            <label for="email" class="d-block text-light-black">{{ __('Email Address') }}</label>
                            <div class="">
                                <input id="email" type="email" class="login-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="group mgb-20">
                            <label for="password" class="d-block text-light-black">{{ __('Password') }}</label>

                            <div class="">
                                <div class="position-relative">
                                    <input id="password" type="password" class="login-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    {{-- eye icon --}}
                                    <span class="icon-eye icons show-password"><span class="path1"></span><span class="path2"></span></span>
                                    <span class="icon-eye icons hide-password"><span class="path1"></span><span class="path2"></span></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="group mgb-40">
                            <div class="">
                                <div class="checkbox-group">
                                    <input class="checkbox-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="checkbox-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="d-flex">
                                @if (Route::has('password.request'))
                                    <a class="button button-transparent w-100" href="{{ route('password.request') }}">
                                        {{ __('Forgot password') }}
                                    </a>
                                @endif
                                <button type="submit" class="button button-primary w-100 mgl-24">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="right-side col-md-6">
                <div class="d-flex right-side-box align-items-center">
                    <img class="mgr-20" src="{{ asset('img/sidebar-logo.png') }}" alt="boston logo">
                    <p class="mb-0 text-white fw-bold ">{{ config()->get('app.name') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.hide-password').hide();
        });

        $('.show-password').on('click', function () {
            $('.show-password').hide();
            $('.hide-password').show();
            $("#password").attr("type", "text");
        });
        $('.hide-password').on('click', function () {
            $('.show-password').show();
            $('.hide-password').hide();
            $("#password").attr("type", "password");
        });
    </script>
@endsection
