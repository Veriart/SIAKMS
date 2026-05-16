<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;

class AcademicYearApiController extends Controller
{
    /**
     * GET /api/academic-years
     * Daftar tahun akademik.
     */
    public function index()
    {
        $years = AcademicYear::orderBy('in', 'desc')->get()->map(function ($ay) {
            return [
                'id' => $ay->id,
                'in' => $ay->in,
                'out' => $ay->out ?? $ay->in + 1,
                'label' => $ay->in . ' - ' . ($ay->out ?? $ay->in + 1),
            ];
        });

        return response()->json(['academic_years' => $years]);
    }
}
