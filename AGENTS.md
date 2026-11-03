# Panduan Arsitektur & Aturan Pengembangan (AGENTS.MD)

Dokumen ini berisi panduan teknis lengkap, aturan konvensi, arsitektur sistem, dan petunjuk langkah-demi-langkah bagi pengembang maupun AI agent yang melanjutkan pengembangan sistem **Averroes Digital Islamic School Management System**.

---

## 1. Ikhtisar Proyek

- **Framework:** Laravel 12 (PHP 8.2+)
- **Database:** MySQL
- **Frontend / UI:** Blade Templates, Sneat Bootstrap 5 Admin Template, FontAwesome 6, SweetAlert2, DataTables.
- **Tujuan Sistem:** Pengelolaan menyeluruh operasional sekolah (Santri, Pengajar/Ustadz, Administrasi, PPDB, Penilaian, Presensi, Jurnal Mengajar, Keuangan, Sarpras, dan Manajemen Sistem).

---

## 2. Sistem Role & Hak Akses (Multi-Role Architecture)

Aplikasi Averroes menggunakan relasi **Many-to-Many** antara `users` dan `roles` melalui tabel pivot `role_user`. Satu akun user dapat memiliki banyak peran sekaligus (contoh: akun Super Admin yang merangkap sebagai Ustadz dan Santri).

### A. Konsep Active Role Context (Mode Peran Aktif)
Agar sidebar dan navigasi tidak berantakan saat user memiliki banyak role, sistem menerapkan pola **Active Role Context**:
1. **Penyimpanan Status:** Peran yang sedang aktif disimpan dalam session `session('active_role')`.
2. **Auto-Detect Berdasarkan URL:**
   Di model [app/Models/User.php](app/Models/User.php), accessor `active_role` secara otomatis mendeteksi URL yang sedang diakses:
   - Mengakses `/superadmin/*` ➔ Mode aktif otomatis menjadi `super_admin`.
   - Mengakses `/teacher/*` ➔ Mode aktif otomatis menjadi `teacher`.
   - Mengakses `/administrationadmin/*` ➔ Mode aktif otomatis menjadi `administration_admin`.
   - Mengakses `/student/*` ➔ Mode aktif otomatis menjadi `student`.
   - Mengakses `/treasurer/*` ➔ Mode aktif otomatis menjadi `treasurer`.
   - Mengakses `/parent/*` ➔ Mode aktif otomatis menjadi `parent`.
   - Mengakses `/facilitiesadmin/*` ➔ Mode aktif otomatis menjadi `facilities_admin`.
3. **Fallback:** Jika session kosong dan tidak sedang membuka prefix spesifik, peran aktif mengutamakan `super_admin` (jika user memilikinya), atau role pertama di tabel `roles`.

### B. Role Switcher di Navbar
- Terletak di [resources/views/components/nav.blade.php](resources/views/components/nav.blade.php).
- Dibuat minimalis identik dengan Theme Switcher (`nav-link dropdown-toggle hide-arrow`).
- Menampilkan icon dinamis sesuai peran yang sedang aktif (`fa-crown`, `fa-chalkboard-user`, `fa-user-tie`, dll).
- Hanya muncul jika akun memiliki lebih dari 1 role (`$user->roles->count() > 1`).
- Mengarahkan ke rute `switch.role` (`/switch-role/{roleCode}`) yang dihandle oleh [app/Http/Controllers/RoleSwitchController.php](app/Http/Controllers/RoleSwitchController.php).

### C. Sidebar Dinamis
- Terletak di [resources/views/components/sidenav.blade.php](resources/views/components/sidenav.blade.php).
- **Hanya menampilkan satu komponen sidebar** sesuai `active_role_code`, yaitu `@include('components.sidebar.' . $activeRoleCode)`.
- Link **Logo** dan menu **Beranda** otomatis mengarah ke home dashboard peran yang aktif (`route(str_replace('_', '', $activeRoleCode) . '.home')`).

### D. Otomatisasi Gate di `AppServiceProvider`
Di [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php):
- Gate otomatis dibuat untuk setiap role di database dengan format: `is` + CamelCase dari `code` role.
  - `super_admin` ➔ `isSuperAdmin`
  - `teacher` ➔ `isTeacher`
  - `administration_admin` ➔ `isAdministrationAdmin`
  - `student` ➔ `isStudent`
- **PENTING:** Jika user memiliki peran `super_admin`, Gate otomatis mengembalikan nilai `true` untuk semua gate!

---

## 3. Panduan Menambahkan Role Baru (Step-by-Step Lengkap)

Sebagai contoh kasus nyata, asumsikan kita akan menambahkan role baru: **Kepala Sekolah** dengan kode `head_master`.

### Cheatsheet Format Case untuk Role Baru:
| Komponen | Aturan Case | Contoh untuk Kepala Sekolah |
|---|---|---|
| **Role Code di Database** | `snake_case` | `head_master` |
| **Nama Gate Laravel** | `is` + `PascalCase` | `isHeadMaster` |
| **Prefix & Name Route** | `lowercase` (tanpa spasi & underscore) | `prefix('headmaster')`, `name('headmaster.')` |
| **Folder Controller** | `PascalCase` | `app/Http/Controllers/HeadMaster/` |
| **Folder View Role** | `PascalCase` | `resources/views/roles/HeadMaster/` |
| **Folder View Fitur** | `lowercase` / `snake_case` | `resources/views/roles/HeadMaster/evaluation/` |
| **File Komponen Sidebar** | `components.sidebar.{code_snake_case}` | `resources/views/components/sidebar/head_master.blade.php` |
| **File Blade** | `lowercase` | `index.blade.php`, `create.blade.php` |

---

### Langkah 1: Daftarkan di Database (`RoleSeeder.php`)
Buka [database/seeders/RoleSeeder.php](database/seeders/RoleSeeder.php), tambahkan role ke array `$roles`:
```php
[
    'name' => 'Kepala Sekolah',
    'code' => 'head_master', // WAJIB snake_case unik!
],
```
Jalankan:
```bash
php artisan db:seed --class=RoleSeeder
```
*(Atau tambahkan record baru langsung via menu Super Admin ➔ Database ➔ Tabel `roles`).*

---

### Langkah 2: Buat Controller Dashboard Role
Buat folder baru dengan format **PascalCase**: `app/Http/Controllers/HeadMaster/`.  
Lalu buat file [app/Http/Controllers/HeadMaster/HomeController.php](app/Http/Controllers/HeadMaster/HomeController.php):
```php
<?php

namespace App\Http\Controllers\HeadMaster;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('roles.HeadMaster.home.index');
    }
}
```

---

### Langkah 3: Daftarkan Routing di `routes/web.php`
> ⚠️ **ATURAN WAJIB PREFIX & NAME ROUTE:**  
> Prefix dan nama route role **TIDAK BOLEH** mengandung underscore `_`. Hapus karakter underscore dari `code` role!  
> Karena `MainController` mencari route berdasarkan formula: `str_replace('_', '', $roleCode) . '.home'`.

Tambahkan grup rute di [routes/web.php](routes/web.php) dengan middleware `can:isHeadMaster`:
```php
/**
 * **Head Master Routes**
 */
Route::prefix('headmaster')->name('headmaster.')->middleware(['auth', 'can:isHeadMaster'])->group(function () {
    Route::redirect('/', '/headmaster/home', 301);
    Route::get('home', [\App\Http\Controllers\HeadMaster\HomeController::class, 'index'])->name('home');

    // Fitur-fitur lain khusus Kepala Sekolah diletakkan di sini:
    // Route::prefix('report')->name('report.')->group(...);
});
```
*(Catatan: Gate `isHeadMaster` akan otomatis dibuat oleh `AppServiceProvider` tanpa perlu kamu daftarkan manual).*

---

### Langkah 4: Buat Komponen Sidebar
Nama file komponen sidebar **WAJIB SAMA PERSIS** dengan `code` role di database (menggunakan `snake_case`).  
Buat file [resources/views/components/sidebar/head_master.blade.php](resources/views/components/sidebar/head_master.blade.php):
```blade
<li class="menu-item {{ request()->routeIs('headmaster.home') ? 'active' : '' }}">
    <a href="{{ route('headmaster.home') }}" class="menu-link">
        <i class="menu-icon fa-solid fa-gauge-high fs-6"></i>
        <div class="text-truncate">Dashboard</div>
    </a>
</li>

<li class="menu-item {{ request()->routeIs('headmaster.report.*') ? 'active' : '' }}">
    <a href="{{ route('headmaster.report.index') }}" class="menu-link">
        <i class="menu-icon fa-solid fa-file-signature fs-6"></i>
        <div class="text-truncate">Laporan Evaluasi</div>
    </a>
</li>
```

---

### Langkah 5: Buat View Blade
Buat folder view dengan format **PascalCase**:  
`resources/views/roles/HeadMaster/home/`  
Lalu buat file `index.blade.php`:
```blade
@extends('layouts.app')
@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Dashboard Kepala Sekolah</h4>
    <div class="card">
        <div class="card-body">
            Selamat datang di panel Kepala Sekolah!
        </div>
    </div>
</div>
@endsection
```

---

### Langkah 6: Daftarkan Ikon Role di Navbar Switcher
Buka [resources/views/components/nav.blade.php](resources/views/components/nav.blade.php), tambahkan kondisi icon untuk `head_master` di tombol trigger dan list dropdown:
```blade
{{-- Pada icon trigger utama: --}}
@elseif ($user->active_role_code === 'head_master')
    <i class="fa-solid fa-user-tie fa-xl"></i>

{{-- Pada list item dropdown: --}}
@elseif ($r->code === 'head_master')
    <i class="fa-solid fa-user-tie me-3"></i>
```

---

### Langkah 7: Sinkronisasi URL Auto-Detect di Model User
Buka [app/Models/User.php](app/Models/User.php) pada method `getActiveRoleAttribute()`, daftarkan prefix URL ke role code pada `$prefixRoleMap`:
```php
'headmaster' => 'head_master',
```
Dengan menambahkan baris ini, ketika pengguna mengakses URL apa pun berawalan `/headmaster/*`, sistem otomatis mengaktifkan mode Kepala Sekolah dan menampilkan sidebar Kepala Sekolah tanpa perlu switch manual!

---

### Langkah 8: Bersihkan Cache Rute
Setelah menambahkan rute dan view baru, jalankan:
```bash
php artisan optimize:clear
```

---

## 4. Konvensi Penamaan (Naming Conventions)

Patuhi konvensi berikut tanpa pengecualian:

| Elemen | Aturan Format | Contoh | Catatan |
|---|---|---|---|
| **Role Code di DB** | `snake_case` | `super_admin`, `teacher` | Digunakan untuk nama komponen sidebar dan Gate check. |
| **Prefix & Name Route Role** | Huruf kecil tanpa spasi/underscore | `superadmin`, `superadmin.` | `MainController` mencari route berdasarkan `str_replace('_', '', $roleCode) . '.home'`. |
| **Nama Gate (Laravel Gate)** | `is` + `CamelCase` | `isSuperAdmin`, `isTeacher` | Digenerate otomatis oleh `AppServiceProvider`. |
| **Nama Folder Controller Role** | `PascalCase` | `SuperAdmin`, `AdministrationAdmin` | Diletakkan di bawah `app/Http/Controllers/`. |
| **Nama Controller Fitur** | `{Fitur}Controller.php` | `TeachingJournalController.php` | |
| **Nama Folder View Role** | `PascalCase` | `resources/views/roles/SuperAdmin/` | |
| **Nama Folder View Fitur** | `lowercase` atau `snake_case` | `journal/`, `user/`, `database/` | |
| **Nama Komponen Sidebar** | `components.sidebar.{code}` | `components.sidebar.super_admin.blade.php` | Menggunakan kode snake_case role di database. |
| **Relasi Model (Methods)** | `PascalCase` | `$user->Teacher`, `$user->Student` | Sesuai aturan arsitektur di header model. |

---

## 5. Struktur Direktori Utama

```text
averroes/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── SuperAdmin/             # Controller khusus Super Admin
│   │   │   ├── AdministrationAdmin/    # Controller admin tata usaha / administrasi
│   │   │   ├── Teacher/                # Controller guru / ustadz
│   │   │   ├── StudentRegistrant/      # Controller alur PPDB calon santri
│   │   │   ├── MainController.php      # Redirector utama setelah login
│   │   │   ├── RoleSwitchController.php# Controller peralihan peran aktif
│   │   │   └── AccountController.php   # Edit profil mandiri semua user
│   │   └── Middleware/
│   │       └── CheckPermission.php     # Middleware cek hak akses fitur
│   ├── Models/                         # Eloquent models (User, Teacher, Student, dll)
│   └── Providers/
│       └── AppServiceProvider.php      # Definisi Gates & Blade directives (@errorFeedback)
├── database/
│   ├── migrations/                     # Riwayat skema tabel
│   └── seeders/                        # RoleSeeder, UserSeeder, FeatureSeeder
├── resources/
│   └── views/
│       ├── components/
│       │   ├── nav.blade.php           # Top navbar (Role Switcher, Theme Switcher, Profile)
│       │   ├── sidenav.blade.php       # Layout aside / menu sidebar
│       │   └── sidebar/                # Komponen menu per role (super_admin, teacher, dll)
│       ├── layouts/
│       │   ├── app.blade.php           # Master layout dengan menu & impersonate banner
│       │   └── appwithoutmenu.blade.php# Layout polos tanpa sidebar
│       └── roles/                      # View halaman per role (SuperAdmin, Teacher, dll)
└── routes/
    └── web.php                         # Definisi semua rute aplikasi
```

---

## 6. Fitur Developer & Utilitas Sistem yang Sudah Ada

Aplikasi ini sudah dilengkapi berbagai tool utilitas tingkat lanjut di menu **Super Admin**:

### 1. User Impersonation (Login Sebagai User Lain)
- **Rute:** `POST /superadmin/user/impersonate/{user}` & `GET /impersonate/leave`
- **Controller:** [app/Http/Controllers/SuperAdmin/ImpersonateController.php](app/Http/Controllers/SuperAdmin/ImpersonateController.php)
- **Cara Kerja:** Super Admin dapat mengklik ikon detektif 🕵️‍♂️ (`fa-user-secret`) pada tabel Manajemen User (`/superadmin/user`). Sesi super admin disimpan di `session('impersonate_by')` dan admin langsung masuk ke akun user target.
- **Keluar:** Terdapat sticky banner warna kuning di atas layout dengan tombol hitam *"Kembali ke Super Admin"* yang otomatis mengembalikan sesi semula.

### 2. Backup & Restore Total (Database & Storage)
- **Rute:** `/superadmin/backup/*`
- **Controller:** [app/Http/Controllers/SuperAdmin/BackupController.php](app/Http/Controllers/SuperAdmin/BackupController.php)
- **Pilihan Backup:**
  1. *Backup Database:* Menghasilkan file `.sql`.
  2. *Backup Total:* Menghasilkan file `.zip` berisi dump database `.sql` + seluruh folder `storage/app/public` (dokumen, foto, berkas pendaftaran).
- **Restore:** Mendukung restore langsung dari daftar backup di server maupun upload file `.zip` / `.sql` dari komputer lokal.

### 3. Log Viewer Terintegrasi
- **Rute:** `/superadmin/logviewer`
- **Controller:** [app/Http/Controllers/SuperAdmin/SuperAdminLogViewer.php](app/Http/Controllers/SuperAdmin/SuperAdminLogViewer.php)
- Berguna untuk membaca, mendownload, dan menghapus error log `storage/logs/laravel.log` langsung dari browser tanpa perlu membuka terminal / cPanel.

### 4. Database Inspector & SQL Runner
- **Rute:** `/superadmin/database`
- **Controller:** [app/Http/Controllers/SuperAdmin/SuperAdminDatabase.php](app/Http/Controllers/SuperAdmin/SuperAdminDatabase.php)
- Fitur untuk melihat daftar tabel, isi data tabel, mengedit record secara inline, menghapus data, dan mengeksekusi raw query SQL via web.

### 5. System CLI Runner
- **Rute:** `/superadmin/system`
- **Controller:** [app/Http/Controllers/SuperAdmin/SuperAdminSystem.php](app/Http/Controllers/SuperAdmin/SuperAdminSystem.php)
- Berguna untuk menjalankan perintah artisan (seperti `optimize:clear`, `migrate`, dll) langsung melalui antarmuka web.

---

## 7. Aturan Kritis, Gotchas & Larangan Keras (CRITICAL RULES)

### ⚠️ A. Password Hashing (Jangan Double Hash!)
Model [app/Models/User.php](app/Models/User.php) telah memiliki mutator:
```php
public function setPasswordAttribute($value)
{
    $this->attributes['password'] = Hash::needsRehash($value) ? bcrypt($value) : $value;
}
```
**LARANGAN:** Jangan pernah menjalankan `$userData['password'] = Hash::make($request->password)` di dalam Controller sebelum memanggil `$user->update()` atau `$user->create()`. Hal itu akan menyebabkan password di-hash dua kali (*double hashing*), sehingga user tidak akan pernah bisa login dengan password tersebut! Cukup oper raw string password ke model.

### ⚠️ B. Global Scope `excludeSuperAdmin` pada Teacher & Student
Model [Teacher.php](app/Models/Teacher.php) dan [Student.php](app/Models/Student.php) memiliki global scope `excludeSuperAdmin` yang mengabaikan record dengan `id = 1`.
- **Solusi Aman:** Scope ini sudah disesuaikan agar mengecualikan pemeriksaan jika query mencari `user_id` milik user yang sedang login (`Auth::id()`).
- Di [app/Models/User.php](app/Models/User.php), relasi `$user->Teacher()` dan `$user->Student()` telah ditambahkan `->withoutGlobalScope('excludeSuperAdmin')`.
- Jika membuat query manual yang mencari data santri/guru milik akun super admin, selalu sertakan `withoutGlobalScopes()`.

### ⚠️ C. Auto-Provision Kolom Wajib Child Table saat Assign Role
Tabel `teachers` dan `students` di MySQL memiliki kolom berstatus `NOT NULL` tanpa nilai default:
- Tabel `teachers`: membutuhkan `full_name`, `birth_date`, `birth_place`, `gender`, `type`.
- Tabel `students`: membutuhkan `full_name`, `nis`, `nisn`, `birth_date`, `birth_place`, `gender`, `student_status`.

Setiap kali menambahkan role `teacher` atau `student` ke akun user di [UserController.php](app/Http/Controllers/SuperAdmin/UserController.php), **wajib** mengisi seluruh kolom wajib tersebut dengan nilai default yang aman (termasuk auto-generate NISN unik). Mengabaikan field ini akan memicu error `SQLSTATE[HY000]: General error: 1364 Field '...' doesn't have a default value`.

### ⚠️ D. CSRF Token & Form Method pada AJAX/Modal
Untuk form edit atau update data yang menggunakan metode HTTP `PUT` di dalam modal/script JavaScript:
- Jangan gunakan method `PUT` murni pada headers AJAX jika server LiteSpeed/cPanel menolaknya.
- Gunakan method `POST` dengan parameter `_method: 'PUT'` dan selalu sertakan header:
  `'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')`
  untuk mencegah error `CSRF token mismatch`.

### ⚠️ E. Jam Badal Jurnal Mengajar
Pada fitur Jurnal Mengajar (`TeachingJournalController` di role Teacher dan AdministrationAdmin):
- Field `total_replacement_hours` (Jam Badal) bersifat **opsional / nullable** (default bernilai 0).
- Jangan membuat input ini menjadi `required` di frontend Blade maupun di validasi controller.

### ⚠️ F. Selalu Bersihkan Cache Route di Lingkungan Production
Karena aplikasi menggunakan pencarian nama rute dinamis (`route(str_replace('_', '', $role) . '.home')`), setiap kali menambahkan route baru di server production, **wajib** menjalankan:
```bash
php artisan optimize:clear
```
atau akses menu **Super Admin** ➔ **System** ➔ jalankan command clear cache agar rute baru segera terdeteksi dan tidak melempar `RouteNotFoundException`.

