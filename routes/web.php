<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SheetImportController;
use App\Http\Controllers\ExamAttendanceController;

Route::get('/', function () {
    return redirect('/app/login');
});

// Data sync routes — hanya admin yang login yang boleh akses
Route::middleware(['auth', 'throttle:10,1'])->group(function () {
    Route::get('/data/sync-sheet', [SheetImportController::class, 'sync']);
    Route::get('/data/urole', [SheetImportController::class, 'urole']);
});

// Kartu Ujian - hanya bisa diakses oleh user yang sudah login
Route::get('/kartu-ujian/{student:slug}', function (\App\Models\Student $student) {
    $today = now()->toDateString();

    // Jadwal ujian hari ini (start_date <= today <= end_date)
    $todaySchedules = \App\Models\ScheduleExam::with(['subject', 'teacher.user'])
        ->where('start_date', '<=', $today)
        ->where('end_date', '>=', $today)
        ->get();

    // Jika user login sebagai guru, ambil data teacher
    $loggedInTeacher = null;
    if (auth()->check() && auth()->user()->teacher) {
        $loggedInTeacher = auth()->user()->teacher;
    }

    // Cek absensi yang sudah ada hari ini untuk siswa ini
    $existingAttendances = \App\Models\ExamAttendance::where('student_id', $student->id)
        ->whereIn('schedule_exam_id', $todaySchedules->pluck('id'))
        ->pluck('schedule_exam_id')
        ->toArray();

    return view('pdf.kartu-ujian', compact('student', 'todaySchedules', 'loggedInTeacher', 'existingAttendances'));
})->middleware('auth')->name('kartu.ujian');

// Absensi Ujian - POST route dengan rate limiting
Route::post('/exam-attendance', [ExamAttendanceController::class, 'store'])
    ->middleware(['auth', 'throttle:30,1'])
    ->name('exam.attendance.store');
