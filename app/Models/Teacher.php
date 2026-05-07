<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'identification_number',
        'nuptk',
        'gender',
        'religion',
        'place_of_birth',
        'date_of_birth',
        'address',
        'phone',
        'education_level',
        'education_major',
        'position',
        'join_date',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'join_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scheduleExams()
    {
        return $this->hasMany(ScheduleExam::class);
    }

    /**
     * Relasi penugasan mengajar (teacher_subject pivot).
     */
    public function teachingAssignments()
    {
        return $this->hasMany(TeachingAssignment::class);
    }

    /**
     * Relasi tugas tambahan (non-mengajar).
     */
    public function additionalDuties()
    {
        return $this->hasMany(TeacherAdditionalDuty::class);
    }

    /**
     * Get total jam mengajar untuk periode (academic_year_id) tertentu.
     */
    public function getTotalHours(?int $academicYearId = null): int
    {
        $query = $this->teachingAssignments();

        if ($academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        }

        return (int) $query->sum('hours_per_week');
    }
}
