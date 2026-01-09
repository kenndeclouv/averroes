<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Dokumentasi RoleSeeder
     *
     * Seeder ini bertanggung jawab untuk mengisi tabel role dengan role yang telah ditentukan.
     *
     * Role didefinisikan sebagai array asosiatif dengan kunci berikut:
     * - name: Nama tampilan dari role (misalnya, 'Super Admin').
     * - code: Kode unik yang mewakili role (misalnya, 'super_admin').
     *
     * Untuk menambahkan role baru, cukup tambahkan array asosiatif baru ke array $roles
     * di metode run. Pastikan bahwa 'code' adalah unik untuk menghindari konflik dan menggunakan penulisan snake case
     * karena ini akan sangat berpengaruh jalannya sistem, banyak dari sistem ini menggunakan sistem otomatis jika penulisan code salah,
     * maka akan memicu error yang fatal.
     *
     * Contoh menambahkan role baru:
     * [
     *     'name' => 'Nama Role Baru',
     *     'code' => 'kode_role_baru',
     * ],
     *
     * Setelah mendefinisikan role, seeder akan mengiterasi melalui array $roles
     * dan membuat setiap role di database menggunakan model Role.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'code' => 'super_admin'],
            ['name' => 'Admin Administrasi', 'code' => 'administration_admin'],
            ['name' => 'Ustadz', 'code' => 'teacher'],
            ['name' => 'Santri', 'code' => 'student'],
            ['name' => 'Calon Santri', 'code' => 'student_registrant'],
            ['name' => 'Wali Santri', 'code' => 'parent'],
            ['name' => 'Bendahara', 'code' => 'treasurer'],
            ['name' => 'Sarpras', 'code' => 'facilities_admin'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['code' => $role['code']], $role);
        }
    }
}
