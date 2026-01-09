@php
    $rolePrefix = 'facilitiesadmin';
@endphp

<li class="menu-item {{ request()->routeIs($rolePrefix . '.inventories.*') ? 'open active' : '' }}">
    <a href="{{ route($rolePrefix . '.inventories.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-boxes-stacked fs-6"></i>
        <div class="text-truncate">
            Inventaris
        </div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs($rolePrefix . '.inventories.index') ? 'active' : '' }}">
            <a href="{{ route($rolePrefix . '.inventories.index') }}" class="menu-link">Daftar Barang</a>
        </li>
        <li class="menu-item {{ request()->routeIs($rolePrefix . '.inventories.create') ? 'active' : '' }}">
            <a href="{{ route($rolePrefix . '.inventories.create') }}" class="menu-link">Tambah Barang</a>
        </li>
    </ul>
</li>

{{-- Master Ruangan --}}
<li class="menu-item {{ request()->routeIs($rolePrefix . '.rooms.*') ? 'open active' : '' }}">
    <a href="{{ route($rolePrefix . '.rooms.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-door-open fs-6"></i>
        <div class="text-truncate">
            Master Ruangan
        </div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs($rolePrefix . '.rooms.index') ? 'active' : '' }}">
            <a href="{{ route($rolePrefix . '.rooms.index') }}" class="menu-link">Daftar Ruangan</a>
        </li>
        <li class="menu-item {{ request()->routeIs($rolePrefix . '.rooms.create') ? 'active' : '' }}">
            <a href="{{ route($rolePrefix . '.rooms.create') }}" class="menu-link">Tambah Ruangan</a>
        </li>
    </ul>
</li>
