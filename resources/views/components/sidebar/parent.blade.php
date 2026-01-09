<li class="menu-item {{ request()->routeIs('parent.home') ? 'active' : '' }}">
    <a href="{{ route('parent.home') }}" class="menu-link">
        <i class="menu-icon fa-solid fa-home fs-6"></i>
        <div class="text-truncate">
            Dashboard
        </div>
    </a>
</li>
