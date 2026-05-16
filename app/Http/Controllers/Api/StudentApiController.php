<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    /**
     * GET /api/students
     * Daftar semua siswa dengan relasi.
     */
    public function index(Request $request)
    {
        $query = Student::with([
            'user:id,name,email,status,photo',
            'classroom:id,name',
            'expertise:id,name',
            'academicYear:id,in',
        ]);

        // Filter kelas
        if ($request->has('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        // Filter jurusan
        if ($request->has('expertise_id')) {
            $query->where('expertise_id', $request->expertise_id);
        }

        // Filter tahun akademik
        if ($request->has('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        // Filter status (Student / Alumni)
        if ($request->has('status')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Search by nama
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('identification_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $students = $query->paginate($request->get('per_page', 15));

        return response()->json($students);
    }

    /**
     * GET /api/students/{id}
     * Detail satu siswa.
     */
    public function show(int $id)
    {
        $student = Student::with([
            'user:id,name,email,status,photo',
            'classroom:id,name',
            'expertise:id,name',
            'academicYear:id,in',
        ])->findOrFail($id);

        return response()->json(['student' => $student]);
    }

    /**
     * GET /api/students/me
     * Data siswa milik user yang sedang login.
     */
    public function me(Request $request)
    {
        $student = $request->user()->student;

        if (!$student) {
            return response()->json(['message' => 'Anda bukan siswa.'], 404);
        }

        $student->load([
            'user:id,name,email,status,photo',
            'classroom:id,name',
            'expertise:id,name',
            'academicYear:id,in',
        ]);

        return response()->json(['student' => $student]);
    }
}
