@php
    $user = Auth::user();
@endphp
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    @if (!$user->hasRole('student_registrant'))
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="fa-solid fa-grid-2"></i>
            </a>
        </div>
    @endif
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="sk-grid sk-primary d-none d-lg-block m-2">
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
        {{-- <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> --}}
        <ul class="navbar-nav flex-row align-items-center ms-auto gap-2">
            {{-- @if (!$user->hasRole('student_registrant'))
                <a href="{{ route('chat.index') }}" class="nav-item nav-link cursor-pointer">
                    <i
                        class="fa-solid fa-message-lines fa-xl {{ request()->routeIs('chat.index') ? 'text-primary' : '' }}"></i>
                </a>
            @endif --}}
            <!-- Style Switcher -->
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
            <!-- / Style Switcher-->
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-title="Akun">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-{{ $user->status }} chat-sidebar-avatar" id="avatar-status">
                        <img src="{{ $user->photo }}" alt="Avatar" class="rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item"
                            href="{{ $user?->StudentRegistrant ? route('studentregistrant.home') : route('account.index') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-{{ $user->status }}" id="avatar-status">
                                        <img src="{{ $user->photo }}" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ strtoupper($user->name ?? '-') }}</h6>
                                    <small
                                        class="text-muted">{{ $user->roles->pluck('name')->implode(', ') ?? '-' }}</small>
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
                        <a class="dropdown-item" href="javascript:void()" onclick="showLogoutConfirm();">
                            <i class="fa-solid fa-sign-out-alt fa-lg me-3"></i><span>Log Out</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
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
        })
    }
</script>
