<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityInformation;
use Illuminate\Http\Request;

class ActivityInformationApiController extends Controller
{
    /**
     * GET /api/activity-informations
     * Daftar informasi kegiatan.
     */
    public function index(Request $request)
    {
        $query = ActivityInformation::with([
            'user:id,name',
            'classrooms:id,name',
        ]);

        // Filter target audiens
        if ($request->has('target_audience')) {
            $query->where('target_audience', $request->target_audience);
        }

        // Search by nama kegiatan
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $activities = $query->orderBy('execution_date', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($activities);
    }

    /**
     * GET /api/activity-informations/{id}
     */
    public function show(int $id)
    {
        $activity = ActivityInformation::with([
            'user:id,name',
            'classrooms:id,name',
        ])->findOrFail($id);

        return response()->json(['activity_information' => $activity]);
    }
}
