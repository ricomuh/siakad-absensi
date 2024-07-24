<?php

use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleClassController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Teacher\ScheduleController;
use App\Http\Controllers\Teacher\SubjectController as TeacherSubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return view('dash');
})->middleware(['auth', 'verified'])->name('dashboard');
// Auth::loginUsingId(1);

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::resource('classrooms', ClassRoomController::class);

        Route::post('/classrooms/{classroom}/students', [StudentClassController::class, 'store'])
            ->name('classrooms.students.store');
        Route::delete('/classrooms/{classroom}/students', [StudentClassController::class, 'destroy'])
            ->name('classrooms.students.destroy');

        Route::post('/classrooms/{classroom}/subjects', [SubjectClassController::class, 'store'])
            ->name('classrooms.subjects.store');
        Route::delete('/classrooms/{classroom}/subjects', [SubjectClassController::class, 'destroy'])
            ->name('classrooms.subjects.destroy');

        Route::post('/classrooms/{classroom}/schedules', [ScheduleClassController::class, 'store'])
            ->name('classrooms.schedules.store');
        Route::put('/classrooms/{classroom}/schedules', [ScheduleClassController::class, 'update'])
            ->name('classrooms.schedules.update');
        Route::delete('/classrooms/{schedule}/schedules', [ScheduleClassController::class, 'destroy'])
            ->name('classrooms.schedules.destroy');

        Route::resource('subjects', SubjectController::class);
        Route::resource('students', StudentController::class);
        Route::resource('teachers', TeacherController::class);
    });

    Route::middleware('teacher')
        ->prefix('teacher')
        ->group(function () {
            Route::get('/schedules', [ScheduleController::class, 'index'])->name('teacher.schedules.index');
            Route::get('/subjects', [TeacherSubjectController::class, 'index'])->name('teacher.subjects.index');
            Route::get('/subjects/{classRoom}', [TeacherSubjectController::class, 'show'])->name('teacher.classrooms.show');
        });
});

require __DIR__ . '/auth.php';
