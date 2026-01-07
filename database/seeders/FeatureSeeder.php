<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            'all_feature' => 'Semua Fitur',

            'show_student' => 'Tampilkan Santri',
            'create_student' => 'Tambahkan Santri',
            'edit_student' => 'Edit Santri',
            'delete_student' => 'Hapus Santri',
            'show_teacher' => 'Tampilkan Pegawai',
            'create_teacher' => 'Tambahkan Pegawai',
            'edit_teacher' => 'Edit Pegawai',
            'delete_teacher' => 'Hapus Pegawai',
            'show_student_permit' => 'Tampilkan Izin Santri',
            'create_student_permit' => 'Tambahkan Izin Santri',
            'edit_student_permit' => 'Edit Izin Santri',
            'delete_student_permit' => 'Hapus Izin Santri',
            'show_student_registrant_user' => 'Tampilkan User Calon Santri',
            'create_student_registrant_user' => 'Tambahkan User Calon Santri',
            'edit_student_registrant_user' => 'Edit User Calon Santri',
            'delete_student_registrant_user' => 'Hapus User Calon Santri',
            'show_student_registrant' => 'Tampilkan PPDB Calon Santri',
            'create_student_registrant' => 'Tambahkan PPDB Calon Santri',
            'edit_student_registrant' => 'Edit PPDB Calon Santri',
            'delete_student_registrant' => 'Hapus PPDB Calon Santri',
            'show_room' => 'Tampilkan Ruangan',
            'create_room' => 'Tambahkan Ruangan',
            'edit_room' => 'Edit Ruangan',
            'delete_room' => 'Hapus Ruangan',
            'add_student_to_room' => 'Tambahkan santri ke kamar',
            'delete_student_from_room' => 'Hapus santri dari kamar',
            'add_student_to_class' => 'Tambahkan santri ke kelas',
            'delete_student_from_class' => 'Hapus santri dari kelas',
            'show_class' => 'Tampilkan Kelas',
            'create_class' => 'Tambahkan Kelas',
            'edit_class' => 'Edit Kelas',
            'delete_class' => 'Hapus Kelas',
            'show_announcement' => 'Tampilkan Pengumuman',
            'create_announcement' => 'Tambahkan Pengumuman',
            'edit_announcement' => 'Edit Pengumuman',
            'delete_announcement' => 'Hapus Pengumuman',
            'show_app_setting' => 'Tampilkan Pengaturan',
            'edit_app_setting' => 'Edit Pengaturan',

            'show_transaction' => 'Edit Pengaturan',

            'show_journal' => 'Tampilkan Jurnal Pengajaran',
            'create_journal' => 'Tambahkan Jurnal Pengajaran',
            'edit_journal' => 'Edit Jurnal Pengajaran',
            'delete_journal' => 'Hapus Jurnal Pengajaran',

            'show_teaching_subject' => 'Tampilkan Mata Pelajaran',
            'create_teaching_subject' => 'Tambahkan Mata Pelajaran',
            'edit_teaching_subject' => 'Edit Mata Pelajaran',
            'delete_teaching_subject' => 'Hapus Mata Pelajaran',

        ];

        foreach ($features as $code => $name) {
            Feature::firstOrCreate([
                'code' => $code,
                'name' => $name
            ]);
        };
    }
}
