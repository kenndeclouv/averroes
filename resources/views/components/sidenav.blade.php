<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme pb-5">
    @php
        $user = Auth::user();
        $activeRole = $user?->active_role;
        $activeRoleCode = $user?->active_role_code;
        $homeRoute = str_replace('_', '', $activeRoleCode ?? 'login') . '.home';
        $homeUrl = Route::has($homeRoute) ? route($homeRoute) : url('/');
    @endphp
    <div class="app-brand demo" style="padding-left: 22px">
        <a href="{{ $homeUrl }}" class="app-brand-link">
            <span class="app-brand-logo demo">
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
            <a href="{{ $homeUrl }}" class="menu-link">
                <i class="menu-icon fa-solid fa-house fs-6"></i>
                <div class="text-truncate">
                    Beranda
                </div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu</span>
        </li>

        {{-- Menampilkan menu sidebar sesuai peran yang sedang aktif --}}
        @if ($activeRoleCode && view()->exists('components.sidebar.' . $activeRoleCode))
            @include('components.sidebar.' . $activeRoleCode)
        @else
            @foreach ($user->roles as $role)
                @if (view()->exists('components.sidebar.' . $role->code))
                    @include('components.sidebar.' . $role->code)
                @endif
            @endforeach
        @endif

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
