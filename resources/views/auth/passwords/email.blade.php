@extends('layouts.app')

@section('content')


<div class="login ">
    <div class="d-flex login-row login-space flex-wrap">
        <div class="left-side col-md-6 bg-light-black">
            <a href="{{ route('login') }}" class="back-btn text-white"><img class="mgr-8" src="{{ asset('img/arrow-left.png') }}" alt="boston logo"> Back</a>
            <div class="login-box" id="loginBox">
                <div class="login-header fs-20 text-light-black mgb-32 fw-bold">{{ __('Reset password') }}</div>
                <p class="text-light-black mgb-32" style="max-width: 372px">You can set a recovery email to be able to reset your password & restore access to your Boston Appraisal account.</p>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                    @csrf
                    <div class="row mb-3">
                        <label for="email" class="d-block text-light-black mb-2">{{ __('Email address') }}</label>
                        <div class="">
                            <input id="email" type="text" class="login-input w-100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                        <div class="">
                            <button type="submit" class="button button-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                </form>
            </div>
            <div class="succes-sent" id="sentSuccess">
                Success sent
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
            },
            messages: {
                email: {
                    required: "Email is required",
                },
            }
        });
    </script>
@endsection
