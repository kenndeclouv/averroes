<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme pb-5">
    <div class="app-brand demo" style="padding-left: 22px">
        <a href="{{ route(str_replace('_', '', Auth::user()->roles->first()->code ?? 'login') . '.home') }}"
            class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- <img src="{{ asset(env('APP_LOGO')) }}" alt="{{ config('app.name') . ' logo' }}"
                    style="max-width:40px; border-radius:5px"> --}}
                <i class="icon-averroes fs-2 text-primary"></i>
            </span>
            <span
                class="app-brand-text demo menu-text text-primary fw-semibold ms-2">{{ ucfirst(config('app.name')) }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="fa-solid fa-chevron-left d-flex align-items-center justify-content-center"></i>
        </a>
    </div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('*.home') ? 'active' : '' }}">
            <a href="{{ route(str_replace('_', '', Auth::user()->roles->first()->code ?? 'login') . '.home') }}"
                class="menu-link">
                <i class="menu-icon fa-solid fa-house fs-6"></i>
                <div class="text-truncate">
                    Beranda
                </div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu</span>
        </li>
        {{--
        /**
         * Dokumentasi Penyertaan Sidebar Otomatis
         *
         * Bagian kode ini secara dinamis menyertakan sidebar
         * berdasarkan peran pengguna. Sidebar dibangun menggunakan
         * komponen Blade, yang memungkinkan pendekatan modular dan
         * mudah dipelihara untuk merender menu navigasi.
         *
        {{--
         * Sidebar disertakan menggunakan baris berikut:
         * @foreach (Auth::user()->roles as $role)
         *   @include('components.sidebar.' . $role->code)
         * @endforeach
         *
         * 'Role' pengguna yang terautentikasi menentukan komponen
         * sidebar mana yang dimuat. Komponen sidebar yang tersedia adalah:
         *
         * - components.sidebar.super_admin
         * - components.sidebar.administration_admin
         * - components.sidebar.student
         * - components.sidebar.teacher
         *
         * Pastikan membuat role dan nama sidebar yang sama (GUNAKAN PENULISAN SNAKE CASE)
         * Pendekatan ini memastikan bahwa pengguna hanya melihat item menu
         * yang relevan dengan izin dan peran mereka dalam aplikasi.
         */
        --}}
        @foreach (Auth::user()->roles as $role)
            @include('components.sidebar.' . $role->code)
        @endforeach

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Profile</span>
        </li>
        <li class="menu-item {{ request()->routeIs('account.index') ? 'active' : '' }}">
            <a href="{{ route('account.index') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-address-card fs-6"></i>
                <div class="text-truncate" data-i18n="Profile">Profile</div>
            </a>
        </li>
    </ul>
</aside>
