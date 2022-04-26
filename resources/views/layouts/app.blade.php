<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('icons/icon.css') }}" rel="stylesheet">
    @stack('css')
    @yield('css')
</head>
<body>
<div class="dashboard-main d-flex" id="app">
    @if(auth()->check())
        @include('layouts.partials.sidebar')
    @endif
    <div class="dashboard-main__right flex-grow-1 bg-platinum">
        @if(auth()->check())
            <!-- Header -->
            <header class="dashboard-header d-flex align-items-center justify-content-between bg-white">
                <div class="dashboard-header__left">
                    <p class="text-light-black text-medium mb-0 fs-20">{{ config()->get('app.name') }}</p>
                </div>

                <div class="dashboard-header__right d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <a class="notification-icon fs-3 text-light-black d-flex align-items-center"><span
                                    class="icon-notification"></span></a>
                        <a class="dashboard-icon text-light-black d-flex align-items-center"><span
                                    class="icon-dashboard fs-3"><span class="path1"></span><span
                                        class="path2"></span><span
                                        class="path3"></span><span class="path4"></span></span></a>
                    </div>
                    {{-- dropdown --}}
                    <div class="dropdown profile-drop">
                        <div class="profile d-flex align-items-center justify-content-between" id="dropdownMenuButton1"
                             data-bs-toggle="dropdown"
                             aria-expanded="false">
                           <div class="d-flex align-items-center">
                                <div class="profile__img me-2">
                                    <img src="{{ asset('img/dummy-profile.png') }}" alt="boston profile">
                                </div>
                                <div class="profile__name">
                                    <p class="text-bold text-light-black fs-14 mb-0 fw-bold name">{{ Auth::user()->name }}</p>
                                    <p class="text-gray fs-12 mb-0 text-uppercase">{{ $user_role ?? '' }}</p>
                                </div>
                           </div>
                            <span class="icon-arrow-bottom text-light-black mgl-32"></span>
                        </div>
                        {{-- dropdown content --}}
                        <ul class="dropdown-menu profile-dropdown p-0" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item text-light-black" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M13.2402 2C13.7102 2 14.1002 2.38 14.1002 2.86V21.15C14.1002 21.62 13.7202 22.01 13.2402 22.01C7.35023 22.01 3.24023 17.9 3.24023 12.01C3.24023 6.12 7.36023 2 13.2402 2Z" fill="#2F415E"/>
                                    <path d="M20.5409 11.54L17.7009 8.69C17.4109 8.4 16.9309 8.4 16.6409 8.69C16.3509 8.98 16.3509 9.46 16.6409 9.75L18.2009 11.31H8.63086C8.22086 11.31 7.88086 11.65 7.88086 12.06C7.88086 12.47 8.22086 12.81 8.63086 12.81H18.2009L16.6409 14.37C16.3509 14.66 16.3509 15.14 16.6409 15.43C16.7909 15.58 16.9809 15.65 17.1709 15.65C17.3609 15.65 17.5509 15.58 17.7009 15.43L20.5409 12.58C20.8309 12.3 20.8309 11.83 20.5409 11.54Z" fill="#2F415E"/>
                                    </svg> {{ __('Logout') }}</a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>

            </header>
        @endif
        @yield('content')
    </div>
</div>
<script src="{{ mix('manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
<script>
    $(document).ready(function () {
        $('.crm-select').select2();
    });
    sidebarToggle = () => {
        let sidebarToggle = document.getElementById("sidebar");
        sidebarToggle.classList.toggle("sidebar-collapse");
    }
</script>
@stack('js')
@yield('js')
</body>
</html>
