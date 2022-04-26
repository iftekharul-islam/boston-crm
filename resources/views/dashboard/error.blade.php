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
<div class="error-section">
    <div class="container custom-container">
        <a href="#" class="back-btn text-light-black"><svg class="me-2" width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.56891 0.180005C7.75891 0.180005 7.94891 0.250005 8.09891 0.400004C8.38891 0.690004 8.38891 1.17 8.09891 1.46L2.55891 7L8.09891 12.54C8.38891 12.83 8.38891 13.31 8.09891 13.6C7.80891 13.89 7.32891 13.89 7.03891 13.6L0.968906 7.53C0.678906 7.24 0.678906 6.76 0.968906 6.47L7.03891 0.400004C7.18891 0.250005 7.37891 0.180005 7.56891 0.180005Z" fill="#2F415E"/>
            <path d="M1.67 6.25L18.5 6.25C18.91 6.25 19.25 6.59 19.25 7C19.25 7.41 18.91 7.75 18.5 7.75L1.67 7.75C1.26 7.75 0.92 7.41 0.92 7C0.92 6.59 1.26 6.25 1.67 6.25Z" fill="#2F415E"/>
            </svg>
             Back</a>
        <div class="row">
            <div class="col-md-6">
                <div class="mgb-40">
                    <h1 class="fs-64 fw-bold text-due mb-3">Sorry, Page Not Found</h1>
                    <h2 class="fs-34 mgb-48 fw-bold text-primary">We can’t find the page your are looking for.</h2>
                    <div class="mgb-40">
                        <p class="text-light-black mb-3 fw-bold">What could have caused this?</p>
                        <p class="text-light-black mb-0">Well, we might have removed the page when we redesigned our website.
                            Or the link you clicked might be old and does not work anymore.
                            Or you might have accidentally typed the wrong URL in the address bar.</p>
                    </div>
                    <a href="/" class="button button-yellow px-4">Dashboard</a>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <img src="{{ asset('img/404.png') }}" alt="404" class="img-fluid">
            </div>
        </div>
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
