<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi untuk mengatur opsi SweetAlert berdasarkan tema sistem
    function getSwalOptions(icon, title, text) {
        const htmlStyle = document.documentElement.getAttribute('data-style');
        const isDarkMode = htmlStyle === 'dark' || (htmlStyle !== 'light' && window.matchMedia(
            '(prefers-color-scheme: dark)').matches);

        return {
            icon: icon,
            title: title,
            text: text,
            confirmButtonColor: 'var(--bs-primary)',
            background: isDarkMode ? '#2b2c40' : '#fff',
            color: isDarkMode ? '#b2b2c4' : '#000',
        };
    }
</script>

@if (session('success'))
    <script>
        Swal.fire(getSwalOptions('success', 'Berhasil!', '{{ session('success') }}'));
    </script>
@elseif (session('error'))
    <script>
        Swal.fire(getSwalOptions('error', 'Yahh Error :(', '{{ session('error') }}'));
    </script>
@endif
@if (session('info'))
    <script>
        Swal.fire(getSwalOptions('info', 'Informasi', '{{ session('info') }}'));
    </script>
@endif
@if (session('warning'))
    <script>
        Swal.fire(getSwalOptions('warning', 'Peringatan!', '{{ session('warning') }}'));
    </script>
@endif

@if ($errors->any())
    <script>
        const errorHtml = `
            <ul style="text-align: left; padding: 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `;

        Swal.fire({
            ...getSwalOptions('error', 'Yahh Terjadi Kesalahan :(', ''),
            html: errorHtml,
        });
    </script>
@endif
