<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityInformation extends Model
{
    protected $table = 'activity_informations';

    protected $fillable = [
        'user_id',
        'name',
        'execution_date',
        'execution_place',
        'document_file',
        'target_audience',
        'student_scope',
    ];

    protected $casts = [
        'execution_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'activity_information_classroom')
            ->withPivot('expertise_id');
    }

    /**
     * Get formatted target audience label.
     */
    public function getTargetLabelAttribute(): string
    {
        return match ($this->target_audience) {
            'all' => 'Semua',
            'teachers' => 'Guru',
            'students' => $this->getStudentScopeLabel(),
            default => '-',
        };
    }

    /**
     * Get formatted student scope label.
     */
    protected function getStudentScopeLabel(): string
    {
        if ($this->student_scope === 'all_students') {
            return 'Semua Siswa';
        }

        $classroomNames = $this->classrooms->pluck('name')->join(', ');
        return 'Siswa Kelas: ' . ($classroomNames ?: '-');
    }
}
