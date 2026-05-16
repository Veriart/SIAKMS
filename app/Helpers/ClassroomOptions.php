<?php

namespace App\Helpers;

use App\Models\Student;
use Illuminate\Support\Facades\Cache;

class ClassroomOptions
{
    /**
     * Get cached classroom options with expertise labels.
     * Format: ['classroom_id_expertise_id' => 'X PPLG 1']
     *
     * Cache selama 1 jam — otomatis refresh.
     */
    public static function all(): array
    {
        return Cache::remember('classroom_expertise_options', 3600, function () {
            return Student::with(['classroom', 'expertise'])
                ->get()
                ->unique(fn($s) => $s->classroom_id . '_' . $s->expertise_id)
                ->sortBy(fn($s) => $s->classroom->name . ' ' . ($s->expertise->name ?? ''))
                ->mapWithKeys(function ($student) {
                    $label = trim($student->classroom->name . ' ' . ($student->expertise->name ?? ''));
                    $key   = $student->classroom_id . '_' . $student->expertise_id;
                    return [$key => $label];
                })
                ->toArray();
        });
    }

    /**
     * Get options filtered by class level (X, XI, XII).
     */
    public static function byLevel(string $level): array
    {
        return Cache::remember("classroom_expertise_options_{$level}", 3600, function () use ($level) {
            return Student::with(['classroom', 'expertise'])
                ->whereHas('classroom', fn($q) => $q->where('name', 'LIKE', $level . '%'))
                ->get()
                ->unique(fn($s) => $s->classroom_id . '_' . $s->expertise_id)
                ->sortBy(fn($s) => $s->classroom->name . ' ' . ($s->expertise->name ?? ''))
                ->mapWithKeys(function ($student) {
                    $label = trim($student->classroom->name . ' ' . ($student->expertise->name ?? ''));
                    $key   = $student->classroom_id . '_' . $student->expertise_id;
                    return [$key => $label];
                })
                ->toArray();
        });
    }

    /**
     * Clear semua cache classroom options.
     * Panggil ini setelah import data siswa baru.
     */
    public static function clearCache(): void
    {
        Cache::forget('classroom_expertise_options');
        foreach (['X', 'XI', 'XII'] as $level) {
            Cache::forget("classroom_expertise_options_{$level}");
        }
    }
}
