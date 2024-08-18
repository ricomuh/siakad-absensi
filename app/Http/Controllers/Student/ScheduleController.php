<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // $student = User::find(auth()->id())->with('classRoom.classRoom.subjects.schedules')->first();
        $student = User::with([
            // 'classRoom.classRoom.subjects.subject.schedules'
            'classRoom.classRoom.subjects'
        ])
            ->find(auth()->id());

        $student->classRoom->classRoom->subjects->load([
            'subject.schedules' => function ($query) use ($student) {
                $query->whereIn('class_subject_id', $student->classRoom->classRoom->subjects->pluck('id')->toArray());
            }
        ]);
        // dd($student);

        $classRoom = $student->classRoom->classRoom;

        $schedules = $student->classRoom->classRoom->subjects->map(function ($subject) use ($classRoom) {
            return $subject->subject->schedules->map(function ($schedule) use ($subject, $classRoom) {
                $schedule->subject = $subject->subject;
                $schedule->classRoom = $classRoom;
                return $schedule;
            });
        })->flatten()->groupBy('day')->sortKeys()
            ->map(function ($schedules) {
                return $schedules->sortBy('start_time');
            })->mapWithKeys(function ($schedules, $day) {
                return [$schedules->first()->dayName => $schedules];
            });

        // dd($schedules);
        // return response()->json($schedules);
        return view('teacher.schedules.index', compact('schedules'));
    }
}
