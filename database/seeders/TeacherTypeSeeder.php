<?php

namespace Database\Seeders;

use App\Models\TeacherType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherTypeSeeder extends Seeder
{
    public function run(): void
    {
        $teacherTypes = [

            // Jabatan Fungsional opsinya:
            // 1. Kepala Sekolah
            // 2. Mudir Ma'had
            // 3. Wakil Kepala Sekolah - Humas
            // 4. Wakil Kepala Sekolah - Kurikulum
            // 5. Sarpras
            // 6. Musyrif
            // 7. Tata Usaha
            // 8. Pengajar
            // 9. Lainnya (bisa input tambhan sendiri)

            ['name' => 'Kepala Sekolah', 'slug' => 'kepala-sekolah', 'type' => 'functional_position'],
            ['name' => 'Mudir Ma\'had', 'slug' => 'mudir-ma-had', 'type' => 'functional_position'],
            ['name' => 'Wakil Kepala Sekolah - Humas', 'slug' => 'wakil-kepala-sekolah-humas', 'type' => 'functional_position'],
            ['name' => 'Wakil Kepala Sekolah - Kurikulum', 'slug' => 'wakil-kepala-sekolah-kurikulum', 'type' => 'functional_position'],
            ['name' => 'Sarpras', 'slug' => 'sarpras', 'type' => 'functional_position'],
            ['name' => 'Musyrif', 'slug' => 'musyrif', 'type' => 'functional_position'],
            ['name' => 'Tata Usaha', 'slug' => 'tata-usaha', 'type' => 'functional_position'],
            ['name' => 'Pengajar', 'slug' => 'pengajar', 'type' => 'functional_position'],
            ['name' => 'Lainnya', 'slug' => 'functional_position-lainnya', 'type' => 'functional_position'],

            // Amanah Mengajar opsinya: 
            // 1. Produktif DKV
            // 2. Produktif RPL
            // 3. Diniyah (Kitab)
            // 4. Al-Qur'an
            // 5. IPAS
            // 6. Matematika
            // 7. Bahasa Indonesia
            // 8. Olahraga 
            // 9. Bahasa Inggris 
            // 10. lainnya (bisa mengisi tambahan sendiri)
            // 11. Bahasa Arab 
            // 12. 

            ['name' => 'Produktif DKV', 'slug' => 'produktif-dkv', 'type' => 'teaching_mandatory'],
            ['name' => 'Produktif RPL', 'slug' => 'produktif-rpl', 'type' => 'teaching_mandatory'],
            ['name' => 'Diniyah (Kitab)', 'slug' => 'diniyah-kitab', 'type' => 'teaching_mandatory'],
            ['name' => 'Al-Qur\'an', 'slug' => 'al-quran', 'type' => 'teaching_mandatory'],
            ['name' => 'IPAS', 'slug' => 'ipas', 'type' => 'teaching_mandatory'],
            ['name' => 'Matematika', 'slug' => 'matematika', 'type' => 'teaching_mandatory'],
            ['name' => 'Bahasa Indonesia', 'slug' => 'bahasa-indonesia', 'type' => 'teaching_mandatory'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'type' => 'teaching_mandatory'],
            ['name' => 'Bahasa Inggris', 'slug' => 'bahasa-inggris', 'type' => 'teaching_mandatory'],
            ['name' => 'Bahasa Arab', 'slug' => 'bahasa-arab', 'type' => 'teaching_mandatory'],
            ['name' => 'lainnya', 'slug' => 'teaching_mandatory-lainnya', 'type' => 'teaching_mandatory'],

            // Bendahara
            ['name' => 'Bendahara', 'slug' => 'treasurer', 'type' => 'functional_position'],
        ];

        foreach ($teacherTypes as $teacherType) {
            TeacherType::firstOrCreate(['slug' => $teacherType['slug']], $teacherType);
        }
    }
}
