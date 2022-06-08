@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                   
                </div>
            </div>
        </div>
    </div>
</div> --}}



<div class="login ">
    <div class="d-flex login-row login-space flex-wrap">
        <div class="left-side col-md-6 bg-light-black">
            <a href="{{ route('login') }}" class="back-btn text-white"><img class="mgr-8" src="{{ asset('img/arrow-left.png') }}" alt="boston logo"> Back</a>
            <div class="login-box" id="loginBox">
                <div class="login-header fs-20 text-light-black mgb-32 fw-bold">{{ __('Reset password') }}</div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- <div class="group">
                        <label for="email" class="d-block text-light-black mb-2">{{ __('Email Address') }}</label>

                        <div class="">
                            <input id="email" type="text" class="login-input w-100 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="group">
                        <label for="password" class="d-block text-light-black mb-2">{{ __('Password') }}</label>

                        <div class="">
                            <input id="password" type="password" class="login-input w-100 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="group">
                        <label for="password-confirm" class="d-block text-light-black mb-2">{{ __('Confirm Password') }}</label>

                        <div class="">
                            <input id="password-confirm" type="password" class="login-input w-100" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="group">
                        <div class="text-end">
                            <button type="submit" class="button button-primary px-5">
                                {{ __('Save Password') }}
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
            if ($(".invalid-feedback")){
                setTimeout(function(){
                    $(".invalid-feedback").addClass('d-none');
                }, 6000);
            }
            $("input[type=text]").blur(function () {
                $(this).val($(this).val().trim());
            });
        });

        $('#resetForm').validate({ // initialize the plugin
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 6

                },
                password_confirmation : {
                    minlength : 6,
                    equalTo : "#password"
                }
            },
            messages: {
                email: {
                    required: "Email is required",
                },
                password: {
                    required: "Password is required",
                },
                password_confirmation: {
                    required: "Confirm password is required",
                    equalTo: "Password did not match"
                }
            }
        });
    </script>
@endsection
