<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    /**
     * **Dokumentasi Penamaan Controller**
     *
     * Penamaan controller harus mengikuti konvensi berikut:
     *
     * 1. Buat file terpisah untuk setiap role yang berbeda, dengan format
     *    pascal case, seperti SuperAdmin, AdministrationAdmin.
     *
     * 2. Gunakan format `FiturController` untuk penamaan controller.
     *    Contoh: Jika controller tersebut mengelola fitur home untuk role SuperAdmin,
     *    maka buat controller  `HomeController` di dalam folder SuperAdmin.
     *
     * 3. Pastikan untuk mengikuti konvensi ini agar mudah dikenali dan dikelompokkan
     *    berdasarkan role.
     *
     * 4. Untuk controller yang mengelola fitur umum, gunakan nama yang lebih generik
     *    seperti `MainController`,`AccountController`, dll.
     *
     * 5. Hindari penggunaan singkatan yang tidak umum dan pastikan nama controller
     *    mencerminkan fungsionalitasnya.
     *
     * 6. Gunakan bahasa Inggris!
     *
     *  ©️ 2025 by kenndeclouv
     *  https://kenndeclouv.my.id
     */

    /**
     * **Dokumentasi Penamaan View**
     *
     * Penamaan view harus mengikuti konvensi berikut:
     *
     * 1. Folder berdasarkan role
     *    untuk folder role gunakan pascal case seperti 'SuperAdmin'
     *
     * 2. Gunakan format lowercase untuk nama file view.
     *    Contoh: `home.blade.php`, `addlist.blade.php`.
     *
     * 2. Tempatkan view dalam folder yang sesuai dengan fitur.
     *    Contoh: Untuk view yang terkait dengan fitur registrasi siswa maka student_registrant.
     *
     * 3. Pastikan nama file view mencerminkan fungsionalitasnya.
     *    Hindari penggunaan singkatan yang tidak umum.
     *
     * 4. Gunakan bahasa Inggris dalam penamaan file view untuk memastikan
     *    keterbacaan dan pemahaman yang lebih baik oleh pengembang lain.
     *
     * 5. Pastikan untuk semua folder role memiliki index.blade.php untuk mencegah error
     *
     * 6. jadi kesimpulannya
     *      PascalCase/snake_case/lowercase
     *      AdministrationAdmin/student_registrant/addlist.blade.php
     */
}
