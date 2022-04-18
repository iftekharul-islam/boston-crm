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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('icons/icon.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
<div class="dashboard-main d-flex" id="app">
    @include('layouts.partials.sidebar')
    <div class="dashboard-main__right flex-grow-1 bg-platinum">
        <!-- Header -->
        <header class="dashboard-header d-flex align-items-center justify-content-between bg-white">
            <div class="dashboard-header__left">
                <p class="text-light-black text-medium mb-0 fs-20">Boston appraisal services</p>
            </div>
            <div class="dashboard-header__right d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <router-link to="#" class="notification-icon fs-3 text-light-black d-flex align-items-center"><span
                            class="icon-notification"></span></router-link>
                    <router-link to="#" class="dashboard-icon text-light-black d-flex align-items-center"><span
                            class="icon-dashboard fs-3"><span class="path1"></span><span class="path2"></span><span
                                class="path3"></span><span class="path4"></span></span></router-link>
                </div>
                {{-- dropdown --}}
                <div class="dropdown">
                    <div class="profile d-flex align-items-center " id="dropdownMenuButton1" data-bs-toggle="dropdown"
                         aria-expanded="false">
                        <div class="profile__img me-2">
                            <img src="{{ asset('img/dummy-profile.png') }}" alt="boston profile">
                        </div>
                        <div class="profile__name">
                            <p class="text-bold text-light-black fs-14 mb-0">John doe</p>
                            <p class="text-gray fs-12 mb-0">Admin</p>
                        </div>
                        <span class="icon-arrow-bottom text-light-black mgl-32"></span>
                    </div>
                    {{-- dropdown content --}}
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
        </header>
        @yield('content')
    </div>
</div>
<script src="{{ mix('manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.crm-select').select2();
    });
    sidebarToggle = () => {
        let sidebarToggle = document.getElementById("sidebar");
        sidebarToggle.classList.toggle("sidebar-collapse");
    }
</script>
@stack('scripts')
@yield('scripts')
</body>
</html>
