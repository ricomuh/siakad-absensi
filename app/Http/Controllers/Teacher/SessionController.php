<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectSession;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'class_subject_id' => 'required|exists:class_subjects,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        // generate qr code
        $uuid = (string) Str::uuid();
        $qrCode = new QRCode();
        $image = $qrCode->render($uuid);


        $session = SubjectSession::create([
            'class_subject_id' => $request->class_subject_id,
            'schedule_id' => $request->schedule_id,
            'uuid' => $uuid,
            'qr_code' => $image,
        ]);

        // redirect to show
        return redirect()->route('teacher.sessions.show', $session);
    }

    public function students(SubjectSession $session)
    {
        abort_unless($session->schedule->classSubject->subject->teacher_id === auth()->id(), 403);
        abort_if($session->closed_at, 403);

        // return $session->studentPresents->map(function ($studentPresent) {
        //     return $studentPresent->student;
        // });

        $classroom = $session->schedule->classSubject->classRoom;


        $students = $classroom->students->map(function ($studentRelation) use ($session) {
            $student = $studentRelation->student;
            $studentPresent = $session->studentPresents->firstWhere('student_id', $student->id);
            if ($studentPresent) {
                $student->status = $studentPresent->status;
                $student->studentPresent = $studentPresent;
            } else {
                $student->status = 0;
            }
            return $student;
        });

        return response()->json($students);
    }

    public function show(SubjectSession $session)
    {
        $session->load([
            'schedule.classSubject'
            => [
                'subject',
                'classRoom',

            ]
        ]);

        abort_unless($session->schedule->classSubject->subject->teacher_id === auth()->id(), 403);
        abort_if($session->closed_at, 403);

        return view('teacher.sessions.show', compact('session'));
    }

    public function close(SubjectSession $session)
    {
        // abort_unless($session->schedule->classSubject->subject->teacher_id === auth()->id(), 403);
        // abort_if($session->closed_at, 403);

        $session->update([
            'closed_at' => now()
        ]);

        return redirect()->route('teacher.classrooms.show', $session->schedule->classSubject->classRoom);
    }
}
