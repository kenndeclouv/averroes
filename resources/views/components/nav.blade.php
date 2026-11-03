@php
    $user = Auth::user();
@endphp
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">

        <!-- ========================================== -->
        <!-- MOBILE ONLY VIEW (< 1200px)                -->
        <!-- Left: Profile Avatar with All-in-One Menu  -->
        <!-- Right: Mobile Menu Toggle                  -->
        <!-- ========================================== -->

        <!-- 1. Mobile Profile Avatar Dropdown (Far Left) -->
        <div class="nav-item dropdown dropdown-user mobile-profile-dropdown d-xl-none me-auto">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar avatar-{{ $user->status }} chat-sidebar-avatar" id="avatar-status-mobile">
                    <img src="{{ $user->photo }}" alt="Avatar" class="rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-start shadow py-2" style="min-width: 275px;">
                <!-- User Header Info -->
                <li>
                    <div class="dropdown-item py-2" style="cursor: default;">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-{{ $user->status }}">
                                    <img src="{{ $user->photo }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-0 text-truncate fw-semibold">{{ strtoupper($user->name ?? '-') }}</h6>
                                <small class="text-muted d-block text-truncate">{{ $user->active_role?->name ?? '-' }}</small>
                            </div>
                        </div>
                    </div>
                </li>

                @if ($user && $user->roles->count() > 1)
                    <!-- Multi-Role Switcher Section -->
                    <li><div class="dropdown-divider my-1"></div></li>
                    <li class="dropdown-header text-uppercase text-muted fw-semibold py-1 px-3" style="font-size: 11px; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-arrows-rotate me-1 text-primary"></i> Beralih Peran
                    </li>
                    @foreach ($user->roles as $r)
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2 {{ $user->active_role_code === $r->code ? 'active' : '' }}"
                                href="{{ route('switch.role', $r->code) }}">
                                @if ($r->code === 'super_admin')
                                    <i class="fa-solid fa-crown me-2 text-warning" style="width: 20px;"></i>
                                @elseif ($r->code === 'teacher')
                                    <i class="fa-solid fa-chalkboard-user me-2 text-info" style="width: 20px;"></i>
                                @elseif ($r->code === 'administration_admin')
                                    <i class="fa-solid fa-user-tie me-2 text-success" style="width: 20px;"></i>
                                @elseif ($r->code === 'student')
                                    <i class="fa-solid fa-user-graduate me-2 text-primary" style="width: 20px;"></i>
                                @elseif ($r->code === 'treasurer')
                                    <i class="fa-solid fa-wallet me-2 text-danger" style="width: 20px;"></i>
                                @elseif ($r->code === 'facilities_admin')
                                    <i class="fa-solid fa-screwdriver-wrench me-2 text-secondary" style="width: 20px;"></i>
                                @elseif ($r->code === 'parent')
                                    <i class="fa-solid fa-users me-2 text-dark" style="width: 20px;"></i>
                                @else
                                    <i class="fa-solid fa-user-tag me-2 text-muted" style="width: 20px;"></i>
                                @endif
                                <span class="flex-grow-1">{{ $r->name }}</span>
                                @if ($user->active_role_code === $r->code)
                                    <i class="fa-solid fa-check ms-auto"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                @endif

                <!-- Theme / Style Switcher Section -->
                <li><div class="dropdown-divider my-1"></div></li>
                <li class="dropdown-header text-uppercase text-muted fw-semibold py-1 px-3" style="font-size: 11px; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-palette me-1 text-primary"></i> Tema Tampilan
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0);" data-theme="light">
                        <i class="fa-solid fa-sun me-2 text-warning" style="width: 20px;"></i>
                        <span class="flex-grow-1">Light</span>
                        <i class="fa-solid fa-check ms-auto d-none theme-check"></i>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0);" data-theme="dark">
                        <i class="fa-solid fa-moon me-2 text-primary" style="width: 20px;"></i>
                        <span class="flex-grow-1">Dark</span>
                        <i class="fa-solid fa-check ms-auto d-none theme-check"></i>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0);" data-theme="system">
                        <i class="fa-solid fa-desktop me-2 text-info" style="width: 20px;"></i>
                        <span class="flex-grow-1">System</span>
                        <i class="fa-solid fa-check ms-auto d-none theme-check"></i>
                    </a>
                </li>

                <!-- Profile Link & Logout Section -->
                <li><div class="dropdown-divider my-1"></div></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2"
                        href="{{ $user?->StudentRegistrant ? route('studentregistrant.home') : route('account.index') }}">
                        <i class="fa-solid fa-address-card me-2 text-primary" style="width: 20px;"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2 text-danger" href="javascript:void(0);" onclick="showLogoutConfirm();">
                        <i class="fa-solid fa-sign-out-alt me-2" style="width: 20px;"></i>
                        <span>Log Out</span>
                    </a>
                </li>
            </ul>
        </div>

        @if (!$user->hasRole('student_registrant'))
            <!-- 2. Mobile Sidebar Menu Toggle (Far Right) -->
            <div class="layout-menu-toggle d-xl-none ms-auto">
                <a class="nav-link px-0 text-body" href="javascript:void(0)" title="Menu Navigasi" style="cursor: pointer;">
                    <i class="fa-solid fa-grid-2 fa-xl"></i>
                </a>
            </div>
        @endif


        <!-- ========================================== -->
        <!-- DESKTOP VIEW (>= 1200px)                   -->
        <!-- Left: Spinner Indicator                    -->
        <!-- Right: Role Switcher, Theme, User Avatar   -->
        <!-- ========================================== -->

        <div class="sk-grid sk-primary d-none d-xl-block m-2">
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
            <div class="sk-grid-cube"></div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto gap-2 d-none d-xl-flex">
            @if ($user && $user->roles->count() > 1)
                <!-- Desktop Role Switcher -->
                <li class="nav-item dropdown-role-switcher dropdown me-2 me-xl-0" data-bs-toggle="tooltip"
                    data-bs-placement="bottom" data-bs-title="Peran: {{ $user->active_role?->name }}">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($user->active_role_code === 'super_admin')
                            <i class="fa-solid fa-crown fa-xl"></i>
                        @elseif ($user->active_role_code === 'teacher')
                            <i class="fa-solid fa-chalkboard-user fa-xl"></i>
                        @elseif ($user->active_role_code === 'administration_admin')
                            <i class="fa-solid fa-user-tie fa-xl"></i>
                        @elseif ($user->active_role_code === 'student')
                            <i class="fa-solid fa-user-graduate fa-xl"></i>
                        @elseif ($user->active_role_code === 'treasurer')
                            <i class="fa-solid fa-wallet fa-xl"></i>
                        @elseif ($user->active_role_code === 'facilities_admin')
                            <i class="fa-solid fa-screwdriver-wrench fa-xl"></i>
                        @elseif ($user->active_role_code === 'parent')
                            <i class="fa-solid fa-users fa-xl"></i>
                        @else
                            <i class="fa-solid fa-user-gear fa-xl"></i>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($user->roles as $r)
                            <li>
                                <a class="dropdown-item {{ $user->active_role_code === $r->code ? 'active' : '' }}"
                                    href="{{ route('switch.role', $r->code) }}">
                                    <span>
                                        @if ($r->code === 'super_admin')
                                            <i class="fa-solid fa-crown me-3"></i>
                                        @elseif ($r->code === 'teacher')
                                            <i class="fa-solid fa-chalkboard-user me-3"></i>
                                        @elseif ($r->code === 'administration_admin')
                                            <i class="fa-solid fa-user-tie me-3"></i>
                                        @elseif ($r->code === 'student')
                                            <i class="fa-solid fa-user-graduate me-3"></i>
                                        @elseif ($r->code === 'treasurer')
                                            <i class="fa-solid fa-wallet me-3"></i>
                                        @elseif ($r->code === 'facilities_admin')
                                            <i class="fa-solid fa-screwdriver-wrench me-3"></i>
                                        @elseif ($r->code === 'parent')
                                            <i class="fa-solid fa-users me-3"></i>
                                        @else
                                            <i class="fa-solid fa-user-tag me-3"></i>
                                        @endif
                                        {{ $r->name }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif

            <!-- Desktop Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-eclipse fa-xl"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span><i class="fa-solid fa-sun me-3"></i>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span><i class="fa-solid fa-moon me-3"></i>Dark</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span><i class="fa-solid fa-desktop me-3"></i>System</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Desktop User Dropdown -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-title="Akun">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-{{ $user->status }} chat-sidebar-avatar" id="avatar-status-desktop">
                        <img src="{{ $user->photo }}" alt="Avatar" class="rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item"
                            href="{{ $user?->StudentRegistrant ? route('studentregistrant.home') : route('account.index') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-{{ $user->status }}">
                                        <img src="{{ $user->photo }}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ strtoupper($user->name ?? '-') }}</h6>
                                    <small class="text-muted d-block">{{ $user->active_role?->name ?? '-' }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="{{ $user?->StudentRegistrant ? route('studentregistrant.home') : route('account.index') }}">
                            <i class="fa-solid fa-address-card fa-lg me-3"></i><span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showLogoutConfirm();">
                            <i class="fa-solid fa-sign-out-alt fa-lg me-3"></i><span>Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Shared Hidden Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script>
    const htmlStyle = document.documentElement.getAttribute('data-style');
    const isDarkMode = htmlStyle === 'dark' || (htmlStyle !== 'light' && window.matchMedia(
        '(prefers-color-scheme: dark)').matches);

    function showLogoutConfirm() {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu akan keluar dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-primary)',
            background: isDarkMode ? '#2b2c40' : '#fff',
            color: isDarkMode ? '#b2b2c4' : '#000',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, keluar!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Theme Switcher Sync & Event Handler
    function syncThemeUI() {
        const currentStyle = localStorage.getItem('templateCustomizer-vertical-menu-template--Style') ||
            document.documentElement.getAttribute('data-style') || 'light';

        document.querySelectorAll('.dropdown-item[data-theme]').forEach(el => {
            const theme = el.getAttribute('data-theme');
            const checkIcon = el.querySelector('.theme-check');
            if (theme === currentStyle) {
                el.classList.add('active');
                if (checkIcon) checkIcon.classList.remove('d-none');
            } else {
                el.classList.remove('active');
                if (checkIcon) checkIcon.classList.add('d-none');
            }
        });
    }

    document.addEventListener('click', function(e) {
        const themeBtn = e.target.closest('.dropdown-item[data-theme]');
        if (themeBtn) {
            e.preventDefault();
            e.stopPropagation();
            const theme = themeBtn.getAttribute('data-theme');
            if (window.templateCustomizer && ['light', 'dark', 'system'].includes(theme)) {
                window.templateCustomizer.setStyle(theme);
            }
        }
    });

    document.addEventListener('DOMContentLoaded', syncThemeUI);
    setTimeout(syncThemeUI, 300);
</script>