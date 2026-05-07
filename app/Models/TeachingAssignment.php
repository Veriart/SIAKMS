<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingAssignment extends Model
{
    protected $table = 'teacher_subject';

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'academic_year_id',
        'classroom_id',
        'expertise_id',
        'hours_per_week',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class);
    }

    /**
     * Get label kelas + jurusan, contoh: "X PPLG 1"
     */
    public function getClassLabelAttribute(): string
    {
        return trim(
            ($this->classroom->name ?? '') . ' ' . ($this->expertise->name ?? '')
        );
    }
}
