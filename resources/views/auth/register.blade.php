@extends('layouts.app')

@section('content')
<div class="login ">
    <div class="d-flex login-row login-space flex-wrap">
        <div class="left-side col-md-6 bg-light-black">
            <a href="#" class="back-btn text-white"><img class="mgr-8" src="{{ asset('img/arrow-left.png') }}" alt="boston logo"> Back</a>
            <div class="login-box">
                <div class="login-header fs-20 text-light-black mgb-48 fw-bold">{{ __('Register') }}</div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="group mgb-40">
                        <label for="name" class="d-block text-light-black">{{ __('Name') }}</label>
                        <div class="">
                            <input id="name" type="text" class="login-input form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
            
                    <div class="group mgb-40">
                        <label for="email" class="d-block text-light-black">{{ __('Email Address') }}</label>
                        <div class="">
                            <input id="email" type="email" class="login-input form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="group mgb-40">
                        <label for="companyName" class="d-block text-light-black">{{ __('Company Name') }}</label>
                        <div class="">
                            <input id="companyName" type="text" class="login-input form-control @error('company_name') is-invalid @enderror" name="company_name" required autocomplete="company-name">           
                            @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
            
                    <div class="group">
                        <label for="password" class="d-block text-light-black">{{ __('Password') }}</label>
                        <div class="">
                            <input id="password" type="password" class="login-input form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="row mb-3">--}}
                    {{-- <label for="password-confirm" class="d-block text-light-black">{{ __('Confirm Password') }}</label>--}}
                    {{-- <div class="">--}}
                    {{-- <input id="password-confirm" type="password" class="login-input form-control" name="password_confirmation" required autocomplete="new-password">--}}
                    {{-- </div>--}}
                    {{-- </div>--}}
                   <div class="d-flex mgt-40">
                        <a href="{{ route('login') }}" class="button button-transparent w-100">Login</a>
                        <button type="submit" class="button button-primary w-100 mgl-24">
                            {{ __('Create') }}
                        </button>
                   </div>
                </form>
            </div>

        </div>
        <div class="right-side col-md-6">
            <div class="d-flex right-side-box align-items-center">
                <img class="mgr-20" src="{{ asset('img/sidebar-logo.png') }}" alt="boston logo">
                <p class="mb-0 text-white fw-bold ">Boston Appraisal
                    Services</p>
            </div>
        </div>
    </div>
</div>

@endsection
