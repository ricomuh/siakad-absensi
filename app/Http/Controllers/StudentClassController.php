<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    public function store(ClassRoom $classroom, Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $studentClass = StudentClass::create([
            'class_room_id' => $classroom->id,
            'student_id' => $request->student_id,
        ]);

        return redirect()->route('classrooms.show', $studentClass->class_room_id)
            ->with('success', 'Student added to class successfully.');
    }

    public function destroy(ClassRoom $classroom, Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $studentClass = StudentClass::where('class_room_id', $classroom->id)
            ->where('student_id', $request->student_id)
            ->first();

        if (!$studentClass)
            return back()->with('error', 'Student not found in class.');

        $studentClass->delete();

        return back()->with('success', 'Student removed from class successfully.');
    }
}
