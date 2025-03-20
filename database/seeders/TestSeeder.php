<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\Message;
use App\Models\Room;
use App\Models\Student;
use App\Models\StudentPermit;
use App\Models\Teacher;
use App\Models\TeacherHasType;
use App\Models\User;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Room
        $rooms = [
            ['name' => 'Ruang 1', 'code' => 'R1'],
            ['name' => 'Ruang 2', 'code' => 'R2'],
            ['name' => 'Ruang 3', 'code' => 'R3'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
        // Class
        $classes = [
            ['name' => 'X', 'code' => 'x'],
            ['name' => 'XI', 'code' => 'xi'],
            ['name' => 'XII', 'code' => 'xii'],
        ];
        foreach ($classes as $class) {
            Classes::create($class);
        }
        // Student
        $students = [
            "Abdullah Faqih Ma'ruf",
            "Abdurrahman Faros Al-hakim",
            "Ghulam Fahry Al-faras",
            "Muhammad Faiz Satrio Gumilang",
            "Muhammad Anabil Faiq",
            "Muhammad Ibrahimovic",
            "Muhammad Ken Izzulhaq",
            "Marvel Arya Al-khaliq",

            "Gunawan Gustav",
            "Aldino Naufal",
            "Al-qaibul Zaky",
            "Fauzan Abdullah Mujahid",
        ];
        foreach ($students as $student) {
            $name = str_replace([" ", "'", "-"], "", strtolower($student));
            $user = User::create([
                'name' => $student,
                'username' => $name,
                'email' => $name . '@example.com',
                'password' => 'password',
                'role_id' => 4,
            ]);
            Student::create([
                'name' => $student,
                'full_name' => $student,
                'nisn' => fake()->unique()->numberBetween(1000000000, 9999999999),
                'user_id' => $user->id,
                'gender' => 'male',
                'birth_date' => fake()->date(),
                'birth_place' => fake()->city(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'education_sd' => fake()->word(),
                'education_smp' => fake()->word(),
                'sibling_info' => fake()->sentence(),
                'quran_memorization' => fake()->numberBetween(1, 30),
                'achievements' => fake()->sentence(),
                'school_motivation' => fake()->sentence(),
                'major' => fake()->randomElement(['RPL', 'DKV']),
                'medical_history' => fake()->sentence(),
                'father_name' => fake()->name(),
                'father_occupation' => fake()->word(),
                'father_income' => fake()->numberBetween(1000000, 10000000),
                'mother_name' => fake()->name(),
                'mother_occupation' => fake()->word(),
                'mother_income' => fake()->numberBetween(1000000, 10000000),
                'parent_whatsapp' => fake()->phoneNumber(),
                'quran_record_link' => fake()->url(),
                'student_status' => fake()->randomElement(['Yatim Piatu', 'Yatim', 'Piatu', 'Non Yatim Piatu']),
            ]);
        }
        // Teacher
        $teachers = [
            "Rujian Khairi",
            "Rafadyaz Raihan",
            "Rafif Suryaatta",
            "Zainal Fatah",
            "Abdurrazaq Assiddiqi Zuhri",
        ];
        foreach ($teachers as $teacher) {
            $name = str_replace([" ", "'", "-"], "", strtolower($teacher));
            $user = User::create([
                'name' => $teacher,
                'username' => $name,
                'email' => $name . '@example.com',
                'password' => 'password',
                'role_id' => 3,
            ]);

            $teacher = Teacher::create([
                'name' => explode(' ', $teacher)[0],
                'full_name' => $teacher,
                'user_id' => $user->id,
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'gender' => 'male',
                'birth_date' => fake()->date(),
                'birth_place' => fake()->city(),
            ]);

            TeacherHasType::create([
                'teacher_id' => $teacher->id,
                'teacher_type_id' => 8,
            ]);
        }
        for ($i = 1; $i <= 30; $i++) {
            StudentPermit::create([
                'student_id' => rand(1, Student::count()),
                'teacher_id' => rand(1, Teacher::count()),
                'from' => fake()->dateTimeBetween('-1 week', 'now'),
                'to' => fake()->dateTimeBetween('now', '+1 week'),
                'reason' => fake()->realText(70),
                'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            ]);
        }

        // for ($i=1; $i < 10; $i++) {
        //     Message::create([
        //         'user_id' => 2,
        //         'recipient_id' => rand(3,9),
        //         'message' => fake()->text(),
        //         'created_at' =>now(),
        //         'updated_at' =>now(),
        //     ]);
        // }
        // for ($i=1; $i < 10; $i++) {
        //     Message::create([
        //         'user_id' => rand(3,9),
        //         'recipient_id' => 2,
        //         'message' => fake()->text(),
        //         'created_at' =>now(),
        //         'updated_at' =>now(),
        //     ]);
        // }
    }
}
