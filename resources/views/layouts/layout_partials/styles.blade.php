<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap">

<!-- Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kenndeclouv/font-awesome@main/v7.2.0/css/all.css">

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css">
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
    class="template-customizer-theme-css">
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}?v={{ file_exists(public_path('assets/css/demo.css')) ? filemtime(public_path('assets/css/demo.css')) : '1.2' }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinner/spinner.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/datatables.net-buttons-bs5@2.2.3/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@form-validation@1.8.1/dist/css/formValidation.min.css"> --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

@yield('page-style')

<link rel="stylesheet" href="{{ asset('assets/font/style.css') }}">

<!-- Mobile Bottom Navbar & Right Sidebar Overrides -->
<style id="mobile-layout-core-override">
@media (max-width: 1199.98px) {
    html body .layout-wrapper:not(.layout-without-menu) .layout-page,
    html body .layout-page,
    html.layout-navbar-fixed body .layout-page {
        padding-top: 0 !important;
    }

    html body #layout-navbar,
    html.layout-navbar-fixed body #layout-navbar,
    html body .layout-navbar.navbar-detached {
        position: fixed !important;
        bottom: calc(0.75rem + env(safe-area-inset-bottom, 0px)) !important;
        top: auto !important;
        left: 0.75rem !important;
        right: 0.75rem !important;
        width: calc(100% - 1.5rem) !important;
        margin: 0 !important;
        z-index: 1075 !important;
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.22) !important;
        border-radius: 0.85rem !important;
    }

    html body .content-wrapper {
        padding-bottom: calc(5.5rem + env(safe-area-inset-bottom, 0px)) !important;
    }

    /* Dropdown Menus Pop UPWARDS on Mobile */
    html body #layout-navbar .dropdown-menu {
        position: absolute !important;
        bottom: 100% !important;
        top: auto !important;
        margin-bottom: 0.65rem !important;
        transform: none !important;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.2) !important;
        max-height: calc(100vh - 6rem) !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.75rem !important;
    }

    /* Mobile Profile Dropdown Anchored to the Left */
    html body #layout-navbar .mobile-profile-dropdown .dropdown-menu,
    html body #layout-navbar .dropdown-menu.dropdown-menu-start {
        left: 0 !important;
        right: auto !important;
        inset: auto auto 100% 0 !important;
        min-width: 270px !important;
        max-width: calc(100vw - 2rem) !important;
    }

    /* Dropdowns that are anchored to the Right */
    html body #layout-navbar .dropdown-menu.dropdown-menu-end:not(.dropdown-menu-start) {
        left: auto !important;
        right: 0 !important;
        inset: auto 0 100% auto !important;
    }

    /* Sidebar Slides In from the RIGHT side */
    html body #layout-menu,
    html body .layout-menu,
    html.layout-navbar-fixed body #layout-menu {
        left: auto !important;
        right: 0 !important;
        transform: translate3d(100%, 0, 0) !important;
        box-shadow: -4px 0 24px rgba(0, 0, 0, 0.25) !important;
        will-change: transform, -webkit-transform;
    }

    html.layout-menu-expanded body #layout-menu,
    html.layout-menu-expanded body .layout-menu {
        transform: translate3d(0, 0, 0) !important;
    }

    #layout-menu .layout-menu-toggle i {
        transform: rotate(180deg) !important;
    }

    .drag-target {
        right: 0 !important;
        left: auto !important;
    }

    body.modal-open #layout-navbar {
        z-index: 1040 !important;
    }
}
</style>
