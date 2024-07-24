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
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        // generate qr code
        $uuid = (string) Str::uuid();
        $qrCode = new QRCode();
        $image = $qrCode->render($uuid);


        $session = SubjectSession::create([
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
        $students = $session->studentPresents->map(function ($studentPresent) {
            return $studentPresent->student;
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

        return redirect()->route('teacher.sessions.show', $session);
    }
}
