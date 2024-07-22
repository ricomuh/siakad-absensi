<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\ClassSubject;
use Illuminate\Http\Request;

class SubjectClassController extends Controller
{
    public function store(ClassRoom $classroom, Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        ClassSubject::create([
            'class_room_id' => $classroom->id,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('classrooms.show', $classroom)
            ->with('success', 'Subject added to class successfully.');
    }

    public function destroy(ClassRoom $classroom, Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $classSubject = ClassSubject::where('class_room_id', $classroom->id)
            ->where('subject_id', $request->subject_id)
            ->first();

        if (!$classSubject)
            return back()->with('error', 'Subject not found in class.');

        $classSubject->schedules()->delete();

        $classSubject->delete();

        return back()->with('success', 'Subject removed from class successfully.');
    }
}
