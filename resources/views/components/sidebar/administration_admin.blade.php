@php
    $permissions = collect(Auth::user()->getPermissionCodes());
    $rolePrefix = 'administrationadmin';
@endphp
@if ($permissions->contains('show_student'))
    <li
        class="menu-item {{ request()->routeIs($rolePrefix . '.student.*') && !request()->routeIs($rolePrefix . '.student.nis.*') ? 'open active' : '' }}">
        <a href="{{ route($rolePrefix . '.student.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-user fs-6"></i>
            <div class="text-truncate">
                Kesantrian
            </div>
        </a>
        <ul class="menu-sub">
            <li
                class="menu-item {{ request()->routeIs($rolePrefix . '.student.index', $rolePrefix . '.student.show', $rolePrefix . '.student.edit') ? 'active' : '' }}">
                <a href="{{ route($rolePrefix . '.student.index') }}" class="menu-link">Data Santri</a>
            </li>
            <li class="menu-item {{ request()->routeIs($rolePrefix . '.student.graduate.index') ? 'active' : '' }}">
                <a href="{{ route($rolePrefix . '.student.graduate.index') }}" class="menu-link">Santri Lulus</a>
            </li>
        </ul>
    </li>
@endif
@if ($permissions->contains('show_teacher'))
    <li
        class="menu-item {{ request()->routeIs($rolePrefix . '.teacher.*') && !request()->routeIs($rolePrefix . '.teacher.nip.*') ? 'open active' : '' }}">
        <a href="{{ route($rolePrefix . '.teacher.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-user-vneck fs-6"></i>
            <div class="text-truncate">
                Kepegawaian
            </div>
        </a>
        <ul class="menu-sub">
            <li
                class="menu-item {{ request()->routeIs($rolePrefix . '.teacher.index', $rolePrefix . '.teacher.show', $rolePrefix . '.teacher.edit') ? 'active' : '' }}">
                <a href="{{ route($rolePrefix . '.teacher.index') }}" class="menu-link">Data Pegawai</a>
            </li>
        </ul>
    </li>
@endif
@if ($permissions->contains('show_student_permit'))
    <li class="menu-item {{ request()->routeIs($rolePrefix . '.studentpermit.index') ? 'open active' : '' }}">
        <a href="{{ route($rolePrefix . '.room.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-school fs-6"></i>
            <div class="text-truncate">
                Kepesantrenan
            </div>
        </a>
        <ul class="menu-sub">
            @if ($permissions->contains('show_student_permit'))
                <li
                    class="menu-item {{ request()->routeIs($rolePrefix . '.studentpermit.index', $rolePrefix . '.studentpermit.show', $rolePrefix . '.studentpermit.edit') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.studentpermit.index') }}" class="menu-link">Data Izin
                        Santri</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if ($permissions->contains('show_student_registrant') || $permissions->contains('show_student_registrant_user'))
    <li class="menu-item {{ request()->routeIs($rolePrefix . '.studentregistrant.*') ? 'open active' : '' }}">
        <a href="{{ route($rolePrefix . '.room.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-screen-users fs-6"></i>
            <div class="text-truncate">
                PPDB
            </div>
        </a>
        <ul class="menu-sub">
            @if ($permissions->contains('show_student_registrant_user'))
                <li
                    class="menu-item {{ request()->routeIs($rolePrefix . '.studentregistrant.index-user', $rolePrefix . '.studentregistrant.create-user', $rolePrefix . '.studentregistrant.edit-user') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.studentregistrant.index-user') }}" class="menu-link">Akun
                        Calon
                        Santri</a>
                </li>
            @endif
            @if ($permissions->contains('show_student_registrant'))
                <li
                    class="menu-item {{ request()->routeIs($rolePrefix . '.studentregistrant.index') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.studentregistrant.index') }}" class="menu-link">List
                        Pendaftar</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if (
    $permissions->contains('show_room') ||
        $permissions->contains('show_class') ||
        $permissions->contains('show_student') ||
        $permissions->contains('show_teacher'))
    <li
        class="menu-item {{ request()->routeIs($rolePrefix . '.class.*', $rolePrefix . '.room.*', $rolePrefix . '.student.nis.*', $rolePrefix . '.teacher.nip.*') ? 'open active' : '' }}">
        <a href="{{ route($rolePrefix . '.class.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-folders fs-6"></i>
            <div class="text-truncate">
                Master Data
            </div>
        </a>
        <ul class="menu-sub">
            @if ($permissions->contains('show_class'))
                <li
                    class="menu-item {{ request()->routeIs($rolePrefix . '.class.index', $rolePrefix . '.class.show', $rolePrefix . '.class.edit') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.class.index') }}" class="menu-link">Master Kelas</a>
                </li>
            @endif
            @if ($permissions->contains('show_room'))
                <li
                    class="menu-item {{ request()->routeIs($rolePrefix . '.room.index', $rolePrefix . '.room.show', $rolePrefix . '.room.edit') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.room.index') }}" class="menu-link">Master Kamar</a>
                </li>
            @endif
            @if ($permissions->contains('show_student'))
                <li
                    class="menu-item {{ request()->routeIs($rolePrefix . '.student.nis.index', $rolePrefix . '.student.nis.show', $rolePrefix . '.student.nis.edit') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.student.nis.index') }}" class="menu-link">Master NIS</a>
                </li>
            @endif
            @if ($permissions->contains('show_teacher'))
                <li
                    class="menu-item {{ request()->routeIs($rolePrefix . '.teacher.nip.index', $rolePrefix . '.teacher.nip.show', $rolePrefix . '.teacher.nip.edit') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.teacher.nip.index') }}" class="menu-link">Master NIP</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if ($permissions->contains('show_transaction'))
    <li class="menu-item {{ request()->routeIs('administrationadmin.transaction.*') ? 'open active' : '' }}">
        <a href="{{ route('administrationadmin.transaction.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-dollar fs-6"></i>
            <div class="text-truncate">
                Transaksi
            </div>
        </a>
        <ul class="menu-sub">
            <li
                class="menu-item {{ request()->routeIs('administrationadmin.transaction.index', 'administrationadmin.transaction.show', 'administrationadmin.transaction.edit') ? 'active' : '' }}">
                <a href="{{ route('administrationadmin.transaction.index') }}" class="menu-link">Daftar Transaksi</a>
            </li>
        </ul>
    </li>
@endif
@if ($permissions->contains('show_journal'))
    <li class="menu-item {{ request()->routeIs('administrationadmin.journals.*') ? 'open active' : '' }}">
        <a href="{{ route('administrationadmin.journals.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-calendar fs-6"></i>
            <div class="text-truncate">
                Jurnal Mengajar
            </div>
        </a>
        <ul class="menu-sub">
            <li
                class="menu-item {{ request()->routeIs('administrationadmin.journals.index', 'administrationadmin.journals.show', 'administrationadmin.journals.edit') ? 'active' : '' }}">
                <a href="{{ route('administrationadmin.journals.index') }}" class="menu-link">Daftar Jurnal</a>
            </li>
        </ul>
    </li>
@endif
@if ($permissions->contains('show_teaching_subject'))
    <li class="menu-item {{ request()->routeIs('administrationadmin.teaching-subjects.*') ? 'open active' : '' }}">
        <a href="{{ route('administrationadmin.teaching-subjects.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-book fs-6"></i>
            <div class="text-truncate">
                Mata Pelajaran
            </div>
        </a>
        <ul class="menu-sub">
            <li
                class="menu-item {{ request()->routeIs('administrationadmin.teaching-subjects.index', 'administrationadmin.teaching-subjects.show', 'administrationadmin.teaching-subjects.edit') ? 'active' : '' }}">
                <a href="{{ route('administrationadmin.teaching-subjects.index') }}" class="menu-link">Daftar Mata
                    Pelajaran</a>
            </li>
        </ul>
    </li>
@endif
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Tools</span>
</li>
@if ($permissions->contains('show_announcement'))
    <li class="menu-item {{ request()->routeIs($rolePrefix . '.announcement.*') ? 'open active' : '' }}">
        <a href="{{ route($rolePrefix . '.announcement.index') }}" class="menu-link menu-toggle">
            <i class="menu-icon fa-solid fa-bullhorn fs-6"></i>
            <div class="text-truncate">
                Pengumuman
            </div>
        </a>
        <ul class="menu-sub">
            <li
                class="menu-item {{ request()->routeIs($rolePrefix . '.announcement.index', $rolePrefix . '.announcement.show', $rolePrefix . '.announcement.edit') ? 'active' : '' }}">
                <a href="{{ route($rolePrefix . '.announcement.index') }}" class="menu-link">Daftar Pengumuman</a>
            </li>
            @if ($permissions->contains('create_announcement'))
                <li class="menu-item {{ request()->routeIs($rolePrefix . '.announcement.create') ? 'active' : '' }}">
                    <a href="{{ route($rolePrefix . '.announcement.create') }}" class="menu-link">Tambah
                        Pengumuman</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if ($permissions->contains('show_app_setting'))
    <li class="menu-item {{ request()->routeIs($rolePrefix . '.appsetting.*') ? 'open active' : '' }}">
        <a href="{{ route($rolePrefix . '.appsetting.index') }}" class="menu-link">
            <i class="menu-icon fa-solid fa-gear fs-6"></i>
            <div class="text-truncate">
                Pengaturan
            </div>
        </a>
    </li>
@endif
