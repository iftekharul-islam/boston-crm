<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin | Boston CRM')</title>
    <link rel="stylesheet" href="{{ asset('icons/icon.css') }}">
    <link rel="stylesheet" href="{{ mix("css/app.css" ) }}">
</head>

<body>
    <div id="app">
        @yield("crm-init")
    </div>
</body>

<script src="{{ mix('manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

</html>
