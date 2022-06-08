@extends('layouts.app')

@section('content')
    <div class="login ">
        <div class="d-flex login-row login-space flex-wrap">
            <div class="left-side col-md-6 bg-light-black">
                <div class="login-box">
                    @if(Session::has('inactive-user'))
                        <p class="text-danger">{{Session::get('inactive-user')}}</p>
                    @endif
                    <div class="login-header fs-20 text-light-black mgb-48 fw-bold">{{ __('Login') }}</div>
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="group mgb-40">
                            <label for="email" class="d-block text-light-black mb-2">{{ __('Email address') }}</label>
                            <div class="">
                                <input id="email" type="email"
                                       class="login-input w-100 @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="group mgb-20">
                            <label for="password" class="d-block text-light-black mb-2">{{ __('Password') }}</label>

                            <div class="">
                                <div class="position-relative">
                                    <input id="password" type="password"
                                           class="login-input w-100 @error('email') is-invalid @enderror"
                                           name="password" autocomplete="password" autofocus>
                                    {{-- eye icon --}}
                                    <span class="icon-eye icons show-password"><span class="path1"></span><span
                                                class="path2"></span></span>
                                    <span class="icon-eye-slash icons hide-password"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span></span>
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
                                    <input class="checkbox-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

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
        $(document).ready(function () {
            $('.hide-password').hide();
            if ($(".invalid-feedback")){
                setTimeout(function(){
                    $(".invalid-feedback").addClass('d-none');
                }, 6000);
            }
            $("input[type=text]").blur(function () {
                $(this).val($(this).val().trim());
            });
        });
        $('#loginForm').validate({ // initialize the plugin
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 6

                },
            },
            messages: {
                email: {
                    required: "Email is required",
                },
                password: {
                    required: "Password is required",
                },
            }
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
