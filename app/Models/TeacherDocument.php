<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherDocument extends Model
{
    protected $fillable = [
        'teacher_id',
        'document_name',
        'file_path',
        'notes',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
