<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = ClassRoom::with('teacher')->withCount('students', 'subjects')->get();

        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::teachers()->get();

        return view('classrooms.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'grade' => 'required|numeric|between:1,12',
            'teacher_id' => 'required|exists:users,id'
        ]);

        ClassRoom::create($request->all());

        return redirect()->route('classrooms.index')->with('success', 'Classroom created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $classroom)
    {
        // $classroom->load('teacher', 'students.student', 'subjects.subject');
        $classroom->load([
            'teacher',
            'students.student',
            'subjects' => ['subject', 'schedules']
        ]);
        // dd($classroom);

        // flatten the students array
        $students = $classroom->students->pluck('student')->all();

        return view('classrooms.show', compact('classroom', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoom $classroom)
    {
        $teachers = User::teachers()->get();

        return view('classrooms.edit', compact('classroom', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassRoom $classroom)
    {
        $request->validate([
            'name' => 'required',
            'grade' => 'required|numeric|between:1,12',
            'teacher_id' => 'required|exists:users,id'
        ]);

        $classroom->update($request->all());

        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classroom)
    {
        $classroom->students()->delete();

        $classroom->delete();

        return redirect()->route('classrooms.index')->with('success', 'Classroom deleted successfully.');
    }
}
