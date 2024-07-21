<?php

namespace Database\Seeders;

use App\Models\ClassSubject;
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
        ]);

        $createdSubjects = collect();

        $classRooms = $grades->map(function ($grade) use ($teachers, $createdSubjects) {
            $createdSubjects->push(
                \App\Models\Subject::factory(5)->create([
                    'grade' => $grade,
                    'teacher_id' => $teachers->random()->id,
                ])
            );

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

                $createdSubjects->each(function ($subjects) use ($class) {
                    $subjects->random()->each(function ($subject) use ($class) {
                        ClassSubject::create([
                            'class_room_id' => $class->id,
                            'subject_id' => $subject->id,
                        ]);
                    });
                });
            });
        });

        // $classRooms->each(function ($classRoom) use ($students) {
        //     $classRoom->each(function ($class) use ($students) {
        //         $students->random(10)->each(function ($student) use ($class) {
        //             $class->students()->attach($student->id);
        //         });

        //         $class->classSubjects()->attach(
        //             $class->students->pluck('id')->map(function ($studentId) use ($class) {
        //                 return $class->subjects->random()->id;
        //             })
        //         );
        //     });
        // });
    }
}
