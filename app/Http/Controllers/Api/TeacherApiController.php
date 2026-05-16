<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherApiController extends Controller
{
    /**
     * GET /api/teachers
     * Daftar semua guru dengan relasi user, penugasan, dan tugas tambahan.
     */
    public function index(Request $request)
    {
        $query = Teacher::with([
            'user:id,name,email,status,photo',
            'teachingAssignments.subject:id,name',
            'teachingAssignments.classroom:id,name',
            'teachingAssignments.expertise:id,name',
            'teachingAssignments.academicYear:id,in',
            'additionalDuties.academicYear:id,in',
            'documents',
        ]);

        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by nama guru
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $teachers = $query->paginate($request->get('per_page', 15));

        return response()->json($teachers);
    }

    /**
     * GET /api/teachers/{id}
     * Detail satu guru.
     */
    public function show(int $id)
    {
        $teacher = Teacher::with([
            'user:id,name,email,status,photo',
            'teachingAssignments.subject:id,name',
            'teachingAssignments.classroom:id,name',
            'teachingAssignments.expertise:id,name',
            'teachingAssignments.academicYear:id,in',
            'additionalDuties.academicYear:id,in',
            'documents',
        ])->findOrFail($id);

        return response()->json(['teacher' => $teacher]);
    }

    /**
     * GET /api/teachers/me
     * Data guru milik user yang sedang login.
     */
    public function me(Request $request)
    {
        $teacher = $request->user()->teacher;

        if (!$teacher) {
            return response()->json(['message' => 'Anda bukan guru.'], 404);
        }

        $teacher->load([
            'user:id,name,email,status,photo',
            'teachingAssignments.subject:id,name',
            'teachingAssignments.classroom:id,name',
            'teachingAssignments.expertise:id,name',
            'teachingAssignments.academicYear:id,in',
            'additionalDuties.academicYear:id,in',
            'documents',
        ]);

        return response()->json(['teacher' => $teacher]);
    }
}
