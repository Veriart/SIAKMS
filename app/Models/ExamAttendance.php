<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttendance extends Model
{
    protected $fillable = [
        'student_id',
        'schedule_exam_id',
        'teacher_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scheduleExam()
    {
        return $this->belongsTo(ScheduleExam::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
