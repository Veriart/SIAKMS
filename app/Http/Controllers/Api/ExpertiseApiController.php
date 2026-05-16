<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expertise;

class ExpertiseApiController extends Controller
{
    /**
     * GET /api/expertises
     * Daftar semua jurusan.
     */
    public function index()
    {
        $expertises = Expertise::orderBy('name')->get();

        return response()->json(['expertises' => $expertises]);
    }
}
