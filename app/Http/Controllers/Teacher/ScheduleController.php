<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('teacher_id', auth()->id())
            ->with([
                'schedules.classSubject.classRoom',
                'classRooms.classRoom'
            ])
            ->get();
        $classRooms = $subjects->pluck('classRooms')->flatten();
        $schedules = collect($subjects->pluck('schedules')->flatten()->all())->map(function ($schedule) use ($subjects, $classRooms) {
            $schedule->subject = $subjects->firstWhere('id', $schedule->classSubject->subject_id);
            $schedule->classRoom = $schedule->classSubject->classRoom;

            // dd($schedule->subject->name, $schedule->classRoom->name);

            return $schedule;
        })->groupBy('day')->sortKeys()
            ->map(function ($schedules) {
                return $schedules->sortBy('start_time');
            })->mapWithKeys(function ($schedules, $day) {
                return [$schedules->first()->dayName => $schedules];
            });

        // dd($subjects, $schedules);
        return view('teacher.schedules.index', compact('schedules'));
    }
}
