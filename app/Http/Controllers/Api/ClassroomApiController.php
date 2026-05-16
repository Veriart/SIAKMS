<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomApiController extends Controller
{
    /**
     * GET /api/classrooms
     * Daftar semua kelas dengan jumlah siswa.
     */
    public function index()
    {
        $classrooms = Classroom::withCount('students')
            ->orderBy('name')
            ->get();

        return response()->json(['classrooms' => $classrooms]);
    }

    /**
     * GET /api/classrooms/{id}
     * Detail kelas beserta siswa.
     */
    public function show(int $id)
    {
        $classroom = Classroom::with([
            'students.user:id,name,email',
            'students.expertise:id,name',
        ])->withCount('students')->findOrFail($id);

        return response()->json(['classroom' => $classroom]);
    }
}
