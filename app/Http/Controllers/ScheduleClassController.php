<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\ClassSubject;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleClassController extends Controller
{
    public function store(ClassRoom $classroom, Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'day' => 'required|between:0,7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $classSubject = ClassSubject::where('class_room_id', $classroom->id)
            ->where('subject_id', $request->subject_id)
            ->first();

        if (!$classSubject)
            return back()->with('error', 'Subject not found in class.');

        $classSubject->schedules()->create($request->only('day', 'start_time', 'end_time'));

        return back()->with('success', 'Schedule added to class successfully.');
    }

    public function update(ClassRoom $classroom, Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'schedule_id' => 'required|exists:class_schedules,id',
            'day' => 'required|between:0,7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $classSubject = ClassSubject::where('class_room_id', $classroom->id)
            ->where('subject_id', $request->subject_id)
            ->first();

        if (!$classSubject)
            return back()->with('error', 'Subject not found in class.');

        $classSubject->schedules()->where('id', $request->schedule_id)->update($request->only('day', 'start_time', 'end_time'));

        return back()->with('success', 'Schedule updated in class successfully.');
    }

    public function destroy(ClassRoom $classroom, Schedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Schedule removed from class successfully.');
    }

    // public function destroy(ClassRoom $classroom, Request $request)
    // {
    //     $request->validate([
    //         'subject_id' => 'required|exists:subjects,id',
    //         'schedule_id' => 'required|exists:class_schedules,id',
    //     ]);

    //     $classSubject = ClassSubject::where('class_room_id', $classroom->id)
    //         ->where('subject_id', $request->subject_id)
    //         ->first();

    //     if (!$classSubject)
    //         return back()->with('error', 'Subject not found in class.');

    //     $classSubject->schedules()->where('id', $request->schedule_id)->delete();

    //     return back()->with('success', 'Schedule removed from class successfully.');
    // }
}
