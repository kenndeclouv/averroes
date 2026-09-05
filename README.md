<p align="center">
<img src="https://raw.githubusercontent.com/KennDeClouv/averroes/ec9596372e7e7b4c8d0fcf640b9381fc0e9c8cca/public/averroes.svg" />
</p>

# **AVERROES DIGITAL ISLAMIC SCHOOL**

Proyek ini adalah aplikasi berbasis Laravel yang bertujuan untuk mengelola sistem manajemen sekolah Averroes Digital Islamic School.

## **Role**

-   Super Admin
-   Administration Admin
-   Teacher
-   Student
-   Student Registrant

## **Cara Instalasi**

Untuk menginstal proyek ini, ikuti langkah-langkah berikut:

1. **Clone Repository**  
   Pertama, clone repository ini ke mesin lokal Kamu menggunakan perintah berikut:

    ```bash
    git clone https://github.com/KennDeClouv/averroes.git
    ```

2. **Masuk ke Direktori Proyek**  
   Setelah cloning selesai, masuk ke direktori proyek:

    ```bash
    cd averroes
    ```

3. **Instalasi Dependensi**  
   Pastikan Kamu memiliki Composer dan Node.js terinstal. Kemudian, jalankan perintah berikut untuk menginstal dependensi PHP dan JavaScript:

    ```bash
    composer install
    ```

4. **Konfigurasi Environment**  
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi sesuai kebutuhan Kamu:

    ```bash
    cp .env.example .env
    ```

5. **Generate Kunci Aplikasi**  
   Jalankan perintah berikut untuk menghasilkan kunci aplikasi:

    ```bash
    php artisan key:generate
    ```

6. **Migrasi Database**  
   Jika Kamu menggunakan database, jalankan migrasi untuk membuat tabel yang diperlukan:

    ```bash
    php artisan migrate --seed
    ```

7. **Menjalankan Aplikasi**  
   Setelah semua langkah di atas selesai, Kamu dapat menjalankan aplikasi dengan perintah:
    ```bash
    php artisan serve
    ```

Aplikasi sekarang dapat diakses di `http://localhost:8000`.

Pastikan untuk memeriksa dokumentasi lebih lanjut untuk konfigurasi dan penggunaan yang lebih mendalam.

# Dokumentasi Penulisan dan Konvensi Proyek

## **Dokumentasi Penamaan Controller**

Penamaan controller harus mengikuti konvensi berikut untuk memastikan keterbacaan, konsistensi, dan kemudahan pemeliharaan kode:

1. **File Terpisah per Role**  
   Setiap role yang berbeda harus memiliki file controller terpisah. Gunakan format penamaan camel case untuk nama file.  
   Contoh: `SuperAdmin.php`, `AdministrationAdmin.php`.  
   Ini membantu dalam mengorganisir kode dan memudahkan pengembang lain untuk menemukan controller yang relevan dengan role tertentu.

2. **Format `FiturController`**  
   Untuk penamaan controller, gunakan format `FiturController`, di mana `Fitur` adalah nama fitur yang dikelola oleh controller tersebut.  
   Contoh: Jika controller tersebut mengelola fitur home untuk role `SuperAdmin`, buat controller dengan nama `HomeController.php` di dalam folder `SuperAdmin`.  
   Ini memberikan kejelasan tentang fungsi controller dan memudahkan pengelompokan berdasarkan fitur.

3. **Konvensi Role**  
   Pastikan untuk mengikuti konvensi penamaan ini agar controller mudah dikenali dan dikelompokkan berdasarkan role.  
   Ini penting untuk menjaga struktur proyek yang terorganisir dan memudahkan kolaborasi antar pengembang.

4. **Penamaan Generik untuk Fitur Umum**  
   Untuk fitur yang bersifat umum dan dapat diakses oleh banyak role, gunakan nama generik seperti `MainController.php`, `AccountController.php`, dan sebagainya.  
   Ini membantu dalam mengidentifikasi controller yang menangani fungsi umum dalam aplikasi.

5. **Hindari Singkatan yang Tidak Umum**  
   Nama controller harus mencerminkan fungsionalitasnya dengan jelas. Hindari penggunaan singkatan yang tidak umum atau ambigu, karena ini dapat membingungkan pengembang lain.  
   Pastikan nama controller memberikan gambaran yang jelas tentang tugas yang dilakukannya.

6. **Gunakan Bahasa Inggris**  
   Semua penamaan, termasuk nama file, variabel, dan struktur proyek, harus menggunakan bahasa Inggris.  
   Ini adalah praktik terbaik untuk memastikan bahwa kode dapat dipahami oleh pengembang dari berbagai latar belakang dan lokasi.

---

## **Dokumentasi dan Aturan Penulisan Route**

1. **Penulisan Nama Alias Class Controller**  
   Gunakan format `RoleFitur` untuk penamaan alias controller.  
   Contoh: Untuk mengelola fitur home pada role `SuperAdmin`, gunakan alias `SuperAdminHome`.  
   Ini membantu dalam mengidentifikasi dengan cepat controller mana yang bertanggung jawab untuk fitur tertentu dalam konteks role.

2. **Menambah Route untuk Role Baru**  
   Format penulisan untuk menambahkan route baru untuk role adalah sebagai berikut:

    ```php
    Route::prefix('role')->name('role.')->middleware(['auth', 'can:isRole'])->group(function () {
        Route::redirect('/', '/role/home', 301); // Redirect ke halaman home role
        Route::get('/home', [RoleHome::class, 'index'])->name('home'); // Route home
        // Tambahkan grup fitur lain untuk role ini di sini
    });
    ```

    Pastikan untuk menambahkan semua route yang relevan untuk role baru di dalam grup ini.

3. **Menambah Fitur di Dalam Route Role**  
   Format penulisan untuk menambahkan fitur di dalam route role adalah sebagai berikut:
    ```php
    Route::prefix('fitur')->name('fitur.')->group(function () {
        Route::get('/', [FiturController::class, 'index'])->name('index'); // Mendapatkan daftar fitur
        Route::post('/create', [FiturController::class, 'create'])->name('create'); // Membuat fitur baru
        Route::put('/update/{id}', [FiturController::class, 'update'])->name('update'); // Memperbarui fitur
        Route::delete('/delete/{id}', [FiturController::class, 'destroy'])->name('delete'); // Menghapus fitur
    });
    ```
    Pastikan untuk mengikuti format ini agar konsistensi dan keterbacaan tetap terjaga.

---

## **Dokumentasi RoleSeeder**

Seeder bertanggung jawab untuk mengisi tabel role dengan data role yang telah ditentukan.

### Struktur Role

Role didefinisikan dalam array asosiatif dengan kunci berikut:

-   `name`: Nama tampilan dari role (misalnya, `Super Admin`).
-   `code`: Kode unik yang mewakili role (misalnya, `super_admin`).

### Menambahkan Role Baru

Untuk menambahkan role baru, tambahkan array asosiatif baru ke `$roles` dalam metode `run`.  
Pastikan:

-   `code` bersifat unik dan menggunakan format **snake_case**.  
    (Kesalahan penulisan dapat memicu error fatal karena sistem otomatis sangat bergantung pada penulisan ini.)

### Contoh:

[
'name' => 'Nama Role Baru',
'code' => 'kode_role_baru',
],

Setelah didefinisikan, seeder akan mengiterasi melalui `$roles` dan membuat setiap role di database menggunakan model `Role`.

---

## **Dokumentasi Penamaan View**

Penamaan view harus mengikuti konvensi berikut:

1.  **Folder berdasarkan role**
    untuk folder role gunakan pascal case seperti 'SuperAdmin'

2.  **Gunakan format lowercase untuk nama file view.**
    Contoh: `home.blade.php`, `addlist.blade.php`.

3.  **Tempatkan view dalam folder yang sesuai dengan fitur.**
    Contoh: Untuk view yang terkait dengan fitur registrasi siswa maka student_registrant.

4.  **Pastikan nama file view mencerminkan fungsionalitasnya.**
    Hindari penggunaan singkatan yang tidak umum.

5.  **Gunakan bahasa Inggris dalam penamaan file view untuk memastikan**
    keterbacaan dan pemahaman yang lebih baik oleh pengembang lain.

6.  **Pastikan untuk semua folder role memiliki index.blade.php untuk mencegah error**

7.  **jadi kesimpulannya**
    PascalCase/snake_case/lowercase
    AdministrationAdmin/student_registrant/addlist.blade.php

## **Catatan Penting**

-   Gunakan konvensi penamaan dan struktur yang dijelaskan di atas untuk menjaga konsistensi dan memudahkan pengelolaan kode.
-   Hindari penggunaan singkatan atau nama yang tidak mencerminkan fungsionalitas dari fitur, controller, atau route.
-   Selalu gunakan bahasa Inggris dalam penamaan file, variabel, dan struktur proyek.

Make with 💝 by [kenndeclouv](https://kenndeclouv.com)
