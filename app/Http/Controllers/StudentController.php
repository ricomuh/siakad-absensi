<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::students()->with('classRoom.classRoom')
            ->when(request('class_room_id'), function ($query) {
                $query->whereHas('classRooms', function ($query) {
                    $query->where('class_room_id', request('class_room_id'));
                });
            })
            ->latest()
            ->get();

        $classRooms = ClassRoom::select('id', 'name')->get();

        return view('students.index', compact('students', 'classRooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role_id' => RoleEnum::STUDENT,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $student)
    {
        $student->load([
            'classRooms' => ['classRoom'],
        ]);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $student->id,
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->reset_password ? bcrypt('password') : $student->password,
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $student->classRooms()->delete();

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
