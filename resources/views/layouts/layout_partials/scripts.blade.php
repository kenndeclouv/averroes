<!-- Core JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/js/bs-stepper.min.js"></script>
<!-- Vendors JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/@form-validation/bootstrap@0.8.1/dist/umd/bootstrap.min.js"></script> --}}
<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    (function() {
        function enforceMobileSidebar() {
            if (window.innerWidth < 1200) {
                document.documentElement.classList.add('mobile-layout');
            } else {
                document.documentElement.classList.remove('mobile-layout');
            }
        }
        enforceMobileSidebar();
        window.addEventListener('resize', enforceMobileSidebar);
    })();
</script>

@yield('page-script')