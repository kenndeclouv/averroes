@php
    $rolePrefix = 'student';
@endphp
<li class="menu-item {{ request()->routeIs($rolePrefix . '.permit.*') ? 'open active' : '' }}">
    <a href="{{ route($rolePrefix . '.permit.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-file-signature fs-6"></i>
        <div class="text-truncate">
            Izin Kamu
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs($rolePrefix . '.permit.index', $rolePrefix . '.permit.show', $rolePrefix . '.permit.edit') ? 'active' : '' }}">
            <a href="{{ route($rolePrefix . '.permit.index') }}" class="menu-link">Daftar Izin Kamu</a>
        </li>
        <li class="menu-item {{ request()->routeIs($rolePrefix . '.permit.create') ? 'active' : '' }}">
            <a href="{{ route($rolePrefix . '.permit.create') }}" class="menu-link">Tambah Izin Kamu</a>
        </li>
    </ul>
</li>

<li class="menu-item {{ request()->routeIs($rolePrefix . '.materials.*') ? 'open active' : '' }}">
    <a href="{{ route($rolePrefix . '.materials.index') }}" class="menu-link">
        <i class="menu-icon fa-solid fa-book-open fs-6"></i>
        <div class="text-truncate">
            Materi Pelajaran
        </div>
    </a>
</li>

<li class="menu-item {{ request()->routeIs($rolePrefix . '.quizzes.*') ? 'open active' : '' }}">
    <a href="{{ route($rolePrefix . '.quizzes.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-file fs-6"></i>
        <div class="text-truncate">
            Ujian
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs($rolePrefix . '.quizzes.index', $rolePrefix . '.quizzes.show', $rolePrefix . '.quizzes.edit') ? 'active' : '' }}">
            <a href="{{ route($rolePrefix . '.quizzes.index') }}" class="menu-link">Daftar Ujian</a>
        </li>
    </ul>
</li>
