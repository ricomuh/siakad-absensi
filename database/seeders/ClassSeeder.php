<?php

namespace Database\Seeders;

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
                ])
            );

            return \App\Models\ClassRoom::factory(3)->create([
                'grade' => $grade,
                'teacher_id' => $teachers->random()->id,
            ]);
        });

        $classRooms->each(function ($classRoom) use ($admins, $students) {
            $classRoom->each(function ($class) use ($admins, $students) {
                $class->subjects()->attach($class->grade, $class->grade + 1, $class->grade + 2);

                $class->students()->attach($students->random(30)->pluck('id'));
                // $class->students()->attach($admins->random(2)->pluck('id'));
            });
        });
    }
}
