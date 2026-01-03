<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with baseline records.
     */
    public function run(): void
    {
        Setting::firstOrCreate([], Setting::defaults());

        $admin = User::updateOrCreate(
            ['email' => 'admin@studentms.com'],
            [
                'name' => 'System Admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $courses = collect([
            [
                'name' => 'Computer Science',
                'duration' => '4 Years',
                'description' => 'Software engineering fundamentals.',
            ],
            [
                'name' => 'Business Management',
                'duration' => '3 Years',
                'description' => 'Finance, marketing, and leadership.',
            ],
            [
                'name' => 'Graphic Design',
                'duration' => '2 Years',
                'description' => 'Design thinking and visual communication.',
            ],
        ])->map(fn (array $course) => Course::updateOrCreate(
            ['name' => $course['name']],
            $course
        ))->values();

        $students = collect([
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@studentms.com',
                'phone' => '1234567890',
                'gender' => 'Female',
                'date_of_birth' => '2004-04-10',
                'course_id' => $courses[0]->id ?? null,
                'admission_date' => Carbon::now()->subMonths(6),
            ],
            [
                'name' => 'Brian Davis',
                'email' => 'brian@studentms.com',
                'phone' => '0987654321',
                'gender' => 'Male',
                'date_of_birth' => '2003-08-21',
                'course_id' => $courses[1]->id ?? null,
                'admission_date' => Carbon::now()->subYear(),
            ],
        ])->map(fn (array $student) => Student::updateOrCreate(
            ['email' => $student['email']],
            $student
        ))->values();

        foreach ($students as $student) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'date' => Carbon::today(),
                ],
                [
                    'status' => 'present',
                    'notes' => 'Seeded attendance record',
                ]
            );

            $total = 42.5 + 48.0;

            Exam::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'course_id' => $student->course_id,
                ],
                [
                    'midterm_score' => 42.5,
                    'final_score' => 48.0,
                    'total_score' => $total,
                    'grade' => Exam::determineGrade($total),
                    'status' => $total >= 50 ? 'pass' : 'fail',
                    'notes' => 'Demo exam record',
                ]
            );
        }
    }
}
