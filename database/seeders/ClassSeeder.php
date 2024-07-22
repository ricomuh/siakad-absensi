<?php

namespace Database\Seeders;

use App\Models\ClassSubject;
use App\Models\Schedule;
use App\Models\StudentClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \Illuminate\Database\Eloquent\Collection $admins
     * @param \Illuminate\Database\Eloquent\Collection $teachers
     * @param \Illuminate\Database\Eloquent\Collection $students
     */
    public function run($admins, $teachers, $students): void
    {
        $grades = collect([7, 8, 9]);

        $subjects = collect([
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'History',
            'Geography',
        ]);

        $createdSubjects = collect();

        $classRooms = $grades->map(function ($grade) use ($teachers, $createdSubjects, $subjects) {
            $subjects->each(function ($subject) use ($grade, $teachers, $createdSubjects) {
                $createdSubjects->push(
                    \App\Models\Subject::create([
                        'name' => $subject,
                        'grade' => $grade,
                        'teacher_id' => $teachers->random()->id,
                    ])
                );
            });

            return \App\Models\ClassRoom::factory(3)->create([
                'grade' => $grade,
                'teacher_id' => $teachers->random()->id,
            ]);
        });

        $classRooms->each(function ($classRoom) use ($students, $createdSubjects) {
            $classRoom->each(function ($class) use ($students, $createdSubjects) {
                $students->random(10)->each(function ($student) use ($class) {
                    // $class->students()->attach($student->id);
                    StudentClass::create([
                        'class_room_id' => $class->id,
                        'student_id' => $student->id,
                    ]);
                });

                $createdSubjects->random(4)->each(function ($subject) use ($class) {
                    $classSubject =
                        ClassSubject::create([
                            'class_room_id' => $class->id,
                            'subject_id' => $subject->id,
                        ]);

                    Schedule::factory(rand(1, 2))->create([
                        'class_subject_id' => $classSubject->id,
                    ]);
                });
            });
        });
    }
}
