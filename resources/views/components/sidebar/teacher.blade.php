<li class="menu-item {{ request()->routeIs('teacher.studentpermit.*') ? 'open active' : '' }}">
    <a href="{{ route('teacher.studentpermit.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-file-signature fs-6"></i>
        <div class="text-truncate">
            Izin Santri
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs('teacher.studentpermit.index', 'teacher.studentpermit.show', 'teacher.studentpermit.edit') ? 'active' : '' }}">
            <a href="{{ route('teacher.studentpermit.index') }}" class="menu-link">Daftar Izin Santri</a>
        </li>
        <li class="menu-item {{ request()->routeIs('teacher.studentpermit.create') ? 'active' : '' }}">
            <a href="{{ route('teacher.studentpermit.create') }}" class="menu-link">Tambah Izin Santri</a>
        </li>
    </ul>
</li>
<li class="menu-item {{ request()->routeIs('teacher.announcement.*') ? 'open active' : '' }}">
    <a href="{{ route('teacher.announcement.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-bullhorn fs-6"></i>
        <div class="text-truncate">
            Pengumuman
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs('teacher.announcement.index', 'teacher.announcement.show', 'teacher.announcement.edit') ? 'active' : '' }}">
            <a href="{{ route('teacher.announcement.index') }}" class="menu-link">Daftar Pengumuman</a>
        </li>
        <li class="menu-item {{ request()->routeIs('teacher.announcement.create') ? 'active' : '' }}">
            <a href="{{ route('teacher.announcement.create') }}" class="menu-link">Tambah Pengumuman</a>
        </li>
    </ul>
</li>
<li class="menu-item {{ request()->routeIs('teacher.journals.*') ? 'open active' : '' }}">
    <a href="{{ route('teacher.journals.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-calendar fs-6"></i>
        <div class="text-truncate">
            Jurnal Mengajar
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs('teacher.journals.index', 'teacher.journals.show', 'teacher.journals.edit') ? 'active' : '' }}">
            <a href="{{ route('teacher.journals.index') }}" class="menu-link">Daftar Jurnal</a>
        </li>
    </ul>
</li>
<li class="menu-item {{ request()->routeIs('teacher.materials.*') ? 'open active' : '' }}">
    <a href="{{ route('teacher.materials.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-book-open fs-6"></i>
        <div class="text-truncate">
            Materi Pelajaran
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs('teacher.materials.index', 'teacher.materials.create', 'teacher.materials.edit') ? 'active' : '' }}">
            <a href="{{ route('teacher.materials.index') }}" class="menu-link">Daftar Materi</a>
        </li>
    </ul>
</li>
<li class="menu-item {{ request()->routeIs('teacher.quizzes.*') ? 'open active' : '' }}">
    <a href="{{ route('teacher.quizzes.index') }}" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-file fs-6"></i>
        <div class="text-truncate">
            Ujian
        </div>
    </a>
    <ul class="menu-sub">
        <li
            class="menu-item {{ request()->routeIs('teacher.quizzes.index', 'teacher.quizzes.show', 'teacher.quizzes.edit') ? 'active' : '' }}">
            <a href="{{ route('teacher.quizzes.index') }}" class="menu-link">Daftar Ujian</a>
        </li>
    </ul>
</li>
