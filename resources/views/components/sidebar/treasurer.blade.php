<li class="menu-item {{ request()->routeIs('treasurer.transaction.*') ? 'open active' : '' }}">
    <a href="{{ route('treasurer.transaction.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-dollar fs-6"></i>
        <div class="text-truncate">
            Transaksi
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs('treasurer.transaction.index', 'treasurer.transaction.show', 'treasurer.transaction.edit') ? 'active' : '' }}">
            <a href="{{ route('treasurer.transaction.index') }}" class="menu-link">Daftar Transaksi</a>
        </li>
        <li class="menu-item {{ request()->routeIs('treasurer.transaction.create') ? 'active' : '' }}">
            <a href="{{ route('treasurer.transaction.create') }}" class="menu-link">Tambah Transaksi</a>
        </li>
    </ul>
</li>
