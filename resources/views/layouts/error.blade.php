<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="layout-navbar-fixed layout-menu-fixed" dir="ltr"
    data-theme="{{ config('app.theme') }}" data-assets-path="{{ config('app.assets_path') }}"
    data-template="{{ config('app.template') }}" data-style="{{ config('app.style') }}"
    data-primary-color="{{ config('app.primary_color') }}" data-themes="{{ config('app.themes') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title>@yield('title') | {{ ucwords(str_replace('_', ' ', config('app.name'))) }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('averroes.svg') }}">
    
    @include('layouts.layout_partials.seo')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap">

    <link href="https://fonts.googleapis.com/css2?family=Bagel+Fat+One&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <!-- Page CSS -->
    <style>
        .misc-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 1.5rem*2);
            text-align: center
        }
    </style>

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    @include('layouts.layout_partials.pwa')
</head>

<body class="vh-100 overflow-hidden">
    <div class="container-xxl container-p-y">
        @yield('content')
    </div>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
