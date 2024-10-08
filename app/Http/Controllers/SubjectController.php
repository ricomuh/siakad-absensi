<?php

namespace App\Http\Controllers;

use App\Models\ClassSubject;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::query()
            ->when(request('grade'), function ($query) {
                $query->where('grade', request('grade'));
            })
            ->when(request('teacher_id'), function ($query) {
                $query->where('teacher_id', request('teacher_id'));
            })
            ->with('teacher')
            ->withCount('classRooms', 'schedules')
            ->latest()
            ->get();

        // dd($subjects);
        $teachers = User::teachers()->get();
        $grades = Subject::select('grade')->distinct()->get()->pluck('grade');

        // return response()->json($subjects);

        return view('subjects.index', compact('subjects', 'teachers', 'grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::teachers()->get();

        return view('subjects.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'grade' => 'required|integer|between:1,12',
            'teacher_id' => 'required|exists:users,id',
        ]);

        Subject::create($request->all());

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load('teacher', 'classRooms.classRoom.teacher', 'schedules.classSubject.classRoom');

        // flatten the class rooms
        $classRooms = $subject->classRooms->pluck('classRoom')->all();

        $schedules = $subject->schedules->groupBy('day')->sortKeys()->map(function ($schedules) {
            return $schedules->sortBy('start_time');
        })->mapWithKeys(function ($schedules, $day) {
            return [$schedules->first()->dayName => $schedules];
        })->map(function ($schedules) {
            return $schedules->map(function ($schedule) {
                $schedule->classroom = $schedule->classSubject->classRoom;

                return $schedule;
            });
        });

        // dd($schedules);


        // dd($subject, $classRooms);

        return view('subjects.show', compact('subject', 'classRooms', 'schedules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $teachers = User::teachers()->get();

        return view('subjects.edit', compact('subject', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string',
            'grade' => 'required|integer|between:1,12',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $subject->update($request->all());

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // dd($subject->classRooms(), $subject->schedules());

        // remove the class rooms that belong to the subject
        // $subject->classRooms()->delete();
        // remove the schedules that belong to the subject
        $classSubjects = ClassSubject::query()->where('subject_id', $subject->id)->get();
        $classSubjects->each(function ($classSubject) {
            $classSubject->schedules()->delete();
            $classSubject->delete();
        });

        $subject->delete();


        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
