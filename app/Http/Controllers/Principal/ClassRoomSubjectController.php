<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\ClassSubject;
use Illuminate\Http\Request;

class ClassRoomSubjectController extends Controller
{
    public function index()
    {
        $classrooms = ClassRoom::with('teacher')->withCount('classSubjects', 'students')->get();

        return view('principal.classroom-subject.index', compact('classrooms'));
    }

    public function show(ClassRoom $classroom)
    {
        $classroom->load('classSubjects.subject.teacher', 'students');

        return view('principal.classroom-subject.show', compact('classroom'));
    }

    public function subject(ClassSubject $classSubject)
    {
        $classSubject->load('subject.teacher', 'students');

        return view('principal.classroom-subject.subject', compact('classSubject'));
    }
}
