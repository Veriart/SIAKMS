<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectApiController extends Controller
{
    /**
     * GET /api/subjects
     * Daftar semua mata pelajaran.
     */
    public function index()
    {
        $subjects = Subject::orderBy('name')->get();

        return response()->json(['subjects' => $subjects]);
    }

    /**
     * GET /api/subjects/{id}
     */
    public function show(int $id)
    {
        $subject = Subject::findOrFail($id);

        return response()->json(['subject' => $subject]);
    }
}
