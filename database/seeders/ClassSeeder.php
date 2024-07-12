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

        $classRooms = $grades->map(function ($grade) use ($teachers) {
            return \App\Models\ClassRoom::factory(3)->create([
                'grade' => $grade,
                'teacher_id' => $teachers->random()->id,
            ]);
        });
    }
}
