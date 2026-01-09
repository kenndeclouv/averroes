<li class="menu-item {{ request()->routeIs('superadmin.admin.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.admin.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-user fs-6"></i>
        <div class="text-truncate">
            Admin
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs('superadmin.admin.index', 'superadmin.admin.show', 'superadmin.admin.edit') ? 'active' : '' }}">
            <a href="{{ route('superadmin.admin.index') }}" class="menu-link">Data Admin</a>
        </li>
        <li class="menu-item {{ request()->routeIs('superadmin.admin.create') ? 'active' : '' }}">
            <a href="{{ route('superadmin.admin.create') }}" class="menu-link">Tambah Admin</a>
        </li>
    </ul>
</li>
<li class="menu-item {{ request()->routeIs('superadmin.user.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.user.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-users fs-6"></i>
        <div class="text-truncate">
            Manajemen User
        </div>
    </a>
</li>
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Tools</span>
</li>
<li class="menu-item {{ request()->routeIs('superadmin.logs.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.logs.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-sheet-plastic fs-6"></i>
        <div class="text-truncate">
            Log
        </div>
    </a>
</li>
<li class="menu-item {{ request()->routeIs('superadmin.foldertree.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.foldertree.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-folder-tree fs-6"></i>
        <div class="text-truncate">
            Folder Tree
        </div>
    </a>
</li>
<li class="menu-item {{ request()->routeIs('superadmin.routelist.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.routelist.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-route fs-6"></i>
        <div class="text-truncate">
            Route List
        </div>
    </a>
</li>
<li class="menu-item {{ request()->routeIs('superadmin.performance.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.performance.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-gauge-max fs-6"></i>
        <div class="text-truncate">
            Performance
        </div>
    </a>
</li>
<li class="menu-item {{ request()->routeIs('superadmin.database.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.database.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-database fs-6"></i>
        <div class="text-truncate">
            Database
        </div>
    </a>
</li>
{{-- <li class="menu-item {{ request()->routeIs('superadmin.system.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.system.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-cogs fs-6"></i>
        <div class="text-truncate">
            System
        </div>
    </a>
</li> --}}
<li class="menu-item {{ request()->routeIs('superadmin.notification.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.notification.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-bell fs-6"></i>
        <div class="text-truncate">
            Notification
        </div>
    </a>
</li>
<li class="menu-item {{ request()->routeIs('superadmin.env.*') ? 'open active' : '' }}">
    <a href="{{ route('superadmin.env.index') }}" class="menu-link ">
        <i class="menu-icon fa-solid fa-gear fs-6"></i>
        <div class="text-truncate">
            System Setting
        </div>
    </a>
</li>

{{-- <li class="menu-header small text-uppercase">
    <span class="menu-header-text">Menu setiap role</span>
</li>
@foreach (App\Models\Role::where('code', '!=', 'super_admin')->get() as $role)
    @if ($role->code == 'student_registrant')
        @continue
    @endif
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ $role->name }}</span>
    </li>
    @include('components.sidebar.' . $role->code)
@endforeach --}}
