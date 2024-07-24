<?php

namespace Database\Seeders;

use App\Models\ClassSubject;
use App\Models\Schedule;
use App\Models\StudentClass;
use App\Models\StudentPresent;
use App\Models\SubjectSession;
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

                $studentsForThisClass = $students->random(20);

                $studentsForThisClass
                    ->each(function ($student) use ($class) {
                        // $class->students()->attach($student->id);
                        StudentClass::create([
                            'class_room_id' => $class->id,
                            'student_id' => $student->id,
                        ]);
                    });

                $createdSubjects->random(4)->each(function ($subject) use ($class, $studentsForThisClass) {
                    $classSubject =
                        ClassSubject::create([
                            'class_room_id' => $class->id,
                            'subject_id' => $subject->id,
                        ]);

                    $schedules =
                        Schedule::factory(rand(1, 2))->create([
                            'class_subject_id' => $classSubject->id,
                        ]);

                    $schedules->each(function ($schedule) use ($studentsForThisClass) {
                        $subjectSessions = SubjectSession::factory(rand(4, 10))->create([
                            'schedule_id' => $schedule->id,
                            'closed_at' => now()
                        ]);

                        $studentsForThisClass->each(function ($student) use ($subjectSessions) {
                            $subjectSessions->random(rand(1, $subjectSessions->count()))
                                ->each(function ($session) use ($student) {
                                    StudentPresent::create([
                                        'student_id' => $student->id,
                                        'subject_session_id' => $session->id,
                                    ]);
                                });
                        });

                        // $studentsForThisClass->each(function ($student) use ($subjectSession) {
                        //     StudentPresent::create([
                        //         'student_id' => $student->id,
                        //         'subject_session_id' => $subjectSession->id,
                        //     ]);
                        // });
                    });
                });
            });
        });
    }
}
