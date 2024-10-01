<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ClassSubject;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SubjectSession;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject
            // ::where('teacher_id', auth()->user()->id)
            ::query()
            ->when(auth()->user()->role_id == RoleEnum::TEACHER, function ($query) {
                $query->where('teacher_id', auth()->id());
            })
            ->with(
                [
                    'classRooms.classRoom' => function ($query) {
                        $query->withCount([
                            'students'
                        ]);
                    },
                ]
            )
            ->withCount([
                'schedules'
            ])
            ->get();

        // dd($subjects);

        return view('teacher.subjects.index', compact('subjects'));
    }

    public function show(ClassRoom $classRoom)
    {
        $classSubject = ClassSubject::where('class_room_id', $classRoom->id)
            // ->whereHas('subject', function ($query) {
            //     $query->where('teacher_id', auth()->id());
            // })
            ->with([
                'classRoom' => function ($query) {
                    $query->with([
                        'teacher',
                        'students.student'
                    ]);
                },
                'subject',
                'schedules.sessions.studentPresents.student'
            ])
            ->first();

        abort_unless(
            $classSubject || auth()->user()->role_id === RoleEnum::PRINCIPAL,
            403
        );

        // dd($classSubject);

        $subject = $classSubject->subject;
        $schedules = $classSubject->schedules;
        $mappedSchedules = $classSubject->schedules
            ->map(function ($schedule) use ($subject) {
                $schedule->subject = $subject;
                return $schedule;
            })
            ->groupBy('day')
            ->sortKeys()
            ->map(function ($daySchedules) {
                return $daySchedules->sortBy('start_time');
            })
            ->mapWithKeys(function ($daySchedules, $day) {
                return [$daySchedules->first()->dayName => $daySchedules];
            });

        $sessions = $schedules->pluck('sessions')->flatten()->sortBy('created_at');
        $classRoom = $classSubject->classRoom;
        $students = $classRoom->students->pluck('student')->map(function ($student) use ($sessions) {
            // $studentSessions = $sessions->map(function ($session) use ($student) {
            //     $studentPresent = $session->studentPresents->firstWhere('student_id', $student->id);
            //     $session->studentPresent = $studentPresent;
            //     return $session;
            // });
            $studentSessions = $sessions->map->studentPresents->flatten()->where('student_id', $student->id);

            $student->sessions_count = $studentSessions->count();

            return $student;
        });

        // check if there is a schedule that is now
        $now = now();
        $currentSchedule = $schedules->first(function ($schedule) use ($now) {
            return $schedule->day === $now->dayOfWeekIso && $schedule->start_time <= $now->format('H:i:s') && $schedule->end_time >= $now->format('H:i:s');
        });

        // dd($schedules);
        return view('teacher.subjects.show', compact('classRoom', 'classSubject', 'students', 'subject', 'mappedSchedules', 'sessions', 'schedules', 'currentSchedule'));
    }

    public function student(ClassSubject $classSubject, User $student)
    {
        $classSubject->load([
            'subject',
            'classRoom',
            'schedules.sessions.studentPresents.student'
        ]);
        $schedules = $classSubject->schedules;
        $sessions = $schedules->pluck('sessions')->flatten();

        $sessions = $sessions->map(function ($session) use ($student) {
            $studentPresent = $session->studentPresents->firstWhere('student_id', $student->id);
            $session->studentPresent = $studentPresent;
            return $session;
        })->sortBy('created_at');
        // dd($studentSessions, $sessions);
        // dd($sessions);

        return view('teacher.subjects.student', compact('student', 'sessions', 'classSubject'));
    }

    public function session(SubjectSession $session)
    {
        $session->load([
            'schedule.classSubject'
            => [
                'subject',
                'classRoom',
            ],
            'studentPresents.student'
        ]);

        return view('teacher.subjects.session', compact('session'));
    }
}
