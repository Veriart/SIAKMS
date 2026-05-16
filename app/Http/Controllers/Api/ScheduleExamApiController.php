<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScheduleExam;
use Illuminate\Http\Request;

class ScheduleExamApiController extends Controller
{
    /**
     * GET /api/schedule-exams
     * Daftar jadwal ujian dengan filter.
     */
    public function index(Request $request)
    {
        $query = ScheduleExam::with([
            'subject:id,name',
            'teacher.user:id,name',
            'academicYear:id,in',
            'classrooms:id,name',
        ]);

        // Filter tahun akademik
        if ($request->has('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        // Filter kategori (UTS, UAS, dll)
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter jadwal hari ini
        if ($request->boolean('today')) {
            $today = now()->toDateString();
            $query->where('start_date', '<=', $today)
                  ->where('end_date', '>=', $today);
        }

        // Filter jadwal yang akan datang
        if ($request->boolean('upcoming')) {
            $query->where('start_date', '>=', now()->toDateString());
        }

        $exams = $query->orderBy('start_date')->paginate($request->get('per_page', 15));

        return response()->json($exams);
    }

    /**
     * GET /api/schedule-exams/{id}
     */
    public function show(int $id)
    {
        $exam = ScheduleExam::with([
            'subject:id,name',
            'teacher.user:id,name',
            'academicYear:id,in',
            'classrooms:id,name',
            'examAttendances.student.user:id,name',
        ])->findOrFail($id);

        return response()->json(['schedule_exam' => $exam]);
    }
}
