<?php

namespace App\Http\Controllers;

use App\Models\ExamAttendance;
use App\Models\ScheduleExam;
use Illuminate\Http\Request;

class ExamAttendanceController extends Controller
{
    /**
     * Store a newly created exam attendance.
     * Teacher (pengawas) is automatically assigned from the logged-in user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'schedule_exam_id' => 'required|exists:schedule_exams,id',
        ]);

        // Pastikan user yang login adalah guru
        $teacher = auth()->user()->teacher;
        if (!$teacher) {
            return back()->with('error', 'Hanya guru yang dapat melakukan absensi.');
        }

        // Pastikan jadwal ujian berlaku hari ini
        $today = now()->toDateString();
        $schedule = ScheduleExam::where('id', $request->schedule_exam_id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();

        if (!$schedule) {
            return back()->with('error', 'Jadwal ujian tidak valid untuk hari ini.');
        }

        // Cek apakah sudah diabsen sebelumnya
        $exists = ExamAttendance::where('student_id', $request->student_id)
            ->where('schedule_exam_id', $request->schedule_exam_id)
            ->exists();

        if ($exists) {
            return back()->with('warning', 'Siswa sudah diabsen untuk mata pelajaran ini.');
        }

        // Simpan absensi dengan teacher_id dari guru yang login
        ExamAttendance::create([
            'student_id' => $request->student_id,
            'schedule_exam_id' => $request->schedule_exam_id,
            'teacher_id' => $teacher->id,
        ]);

        return back()->with('success', 'Absensi berhasil disimpan.');
    }
}

