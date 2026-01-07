<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeachingSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            "AL-QUR'AN / DINIYAH",
            "B. ARAB",
            "B. INGGRIS",
            "PRAKTIKUM DKV",
            "PRAKTIKUM RPL",
            "MAPEL TAMBAHAN"
        ];

        foreach ($subjects as $subject) {
            DB::table('teaching_subjects')->insertOrIgnore([
                'name' => $subject,
                'slug' => Str::slug($subject),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
