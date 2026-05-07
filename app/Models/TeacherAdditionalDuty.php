<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAdditionalDuty extends Model
{
    protected $table = 'teacher_additional_duties';

    protected $fillable = [
        'teacher_id',
        'academic_year_id',
        'duty_name',
        'description',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
