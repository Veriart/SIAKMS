<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleExam extends Model
{
    protected $fillable = [
        'category',
        'academic_year_id',
        'subject_id',
        'type',
        'teacher_id',
        'start_date',
        'end_date',
        'target_class_level',
        'class_scope',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function examAttendances()
    {
        return $this->hasMany(ExamAttendance::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'schedule_exam_classroom')
            ->withPivot('expertise_id');
    }

    /**
     * Get formatted target label for display.
     */
    public function getTargetLabelAttribute(): string
    {
        if ($this->target_class_level === 'all') {
            return 'Semua Kelas';
        }

        $level = $this->target_class_level; // X, XI, XII

        if ($this->class_scope === 'all_classes') {
            return "Kelas {$level} (Semua Jurusan)";
        }

        // Specific classrooms
        $classroomDetails = $this->classrooms()
            ->withPivot('expertise_id')
            ->get()
            ->map(function ($classroom) {
                $expertise = $classroom->pivot->expertise_id
                    ? Expertise::find($classroom->pivot->expertise_id)
                    : null;
                return trim($classroom->name . ' ' . ($expertise->name ?? ''));
            })
            ->join(', ');

        return $classroomDetails ?: '-';
    }
}
