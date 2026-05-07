<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function activityInformations()
    {
        return $this->belongsToMany(ActivityInformation::class, 'activity_information_classroom')
            ->withTimestamps();
    }

    public function scheduleExams()
    {
        return $this->belongsToMany(ScheduleExam::class, 'schedule_exam_classroom')
            ->withPivot('expertise_id');
    }
    
}
