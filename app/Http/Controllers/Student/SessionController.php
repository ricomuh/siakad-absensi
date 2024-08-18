<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentPresent;
use App\Models\SubjectSession;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function present(SubjectSession $session)
    {
        // dd($session);
        // check if the session is not closed
        if ($session->closed_at !== null && $session->closed_at->isPast()) {
            return redirect()->route('student.sessions.page')->with('error', 'Session is closed');
        }

        // check if the student has already presented
        if ($session->studentPresents()->where('student_id', auth()->id())->exists()) {
            return redirect()->route('student.sessions.page')->with('error', 'You have already presented');
        }

        // create a new student present
        StudentPresent::create([
            'student_id' => auth()->id(),
            'subject_session_id' => $session->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'location' => request()->header('x-forwarded-for') ?? request()->header('x-real-ip') ?? request()->ip(),
        ]);

        return redirect()->route('student.sessions.page')->with('success', 'You have successfully presented');
    }

    public function page()
    {
        return view('student.session');
    }
}
