<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeachingAssignment;
use Illuminate\Http\Request;

class TeachingAssignmentApiController extends Controller
{
    /**
     * GET /api/teaching-assignments
     * Daftar penugasan mengajar dengan filter.
     */
    public function index(Request $request)
    {
        $query = TeachingAssignment::with([
            'teacher.user:id,name',
            'subject:id,name',
            'classroom:id,name',
            'expertise:id,name',
            'academicYear:id,in',
        ]);

        // Filter guru
        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        // Filter mata pelajaran
        if ($request->has('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter tahun akademik
        if ($request->has('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        // Filter kelas
        if ($request->has('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        $assignments = $query->paginate($request->get('per_page', 15));

        return response()->json($assignments);
    }
}
