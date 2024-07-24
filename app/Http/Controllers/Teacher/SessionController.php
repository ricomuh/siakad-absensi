<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $session = SubjectSession::create([
            'schedule_id' => $request->schedule_id,
            'uuid' => (string) Str::uuid(),
        ]);
    }
}
