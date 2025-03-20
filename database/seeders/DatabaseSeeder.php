<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            FeatureSeeder::class,
            TeacherTypeSeeder::class
        ]);
        // Super Admin
        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => 'superadmin',
            'role_id' => 1,
        ]);
        Student::create([
            'name' => 'Super Admin',
            'full_name' => 'Super Admin',
            'nisn' => '1234567890',
            'user_id' => $user->id,
            'gender' => 'male',
            'birth_date' => '1990-01-01',
            'birth_place' => 'Jakarta',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 1, Jakarta',
            'education_sd' => 'SDN 01 Jakarta',
            'education_smp' => 'SMPN 01 Jakarta',
            'sibling_info' => '1 saudara',
            'quran_memorization' => 10,
            'achievements' => 'Juara 1 Lomba Matematika',
            'school_motivation' => 'Ingin menjadi programmer',
            'major' => 'RPL',
            'medical_history' => 'Sehat',
            'father_name' => 'Budi Santoso',
            'father_occupation' => 'Pegawai Negeri',
            'father_income' => 5000000,
            'mother_name' => 'Siti Aminah',
            'mother_occupation' => 'Ibu Rumah Tangga',
            'mother_income' => 3000000,
            'parent_whatsapp' => '081234567891',
            'quran_record_link' => 'http://example.com/quran_record',
            'student_status' => 'Non Yatim Piatu',
        ]);
        Teacher::create([
            'name' => 'Super Admin',
            'full_name' => 'Super Admin',
            'user_id' => $user->id,
            'phone' => '081234567892',
            'address' => 'Jl. Merdeka No. 2, Jakarta',
            'gender' => 'male',
            'birth_date' => '1980-01-01',
            'birth_place' => 'Bandung',
        ]);
        // Admin
        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => 'admin',
            'role_id' => 2,
        ]);
        Permission::create([
            'feature_id'=> 1,
            'user_id' => $user->id
        ]);
        $user = User::create([
            'name' => 'Admin 2',
            'username' => 'admin2',
            'email' => 'admin2@example.com',
            'password' => 'admin',
            'role_id' => 2,
        ]);
        for ($i=2; $i < 36; $i++) {
            Permission::create([
                'feature_id'=> $i,
                'user_id' => $user->id
            ]);
        }
        if (env('APP_ENV') === 'local') {
            $this->call(TestSeeder::class);
        }
    }
}
