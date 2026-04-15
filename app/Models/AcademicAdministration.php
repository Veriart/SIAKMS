<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicAdministration extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'academic_year_id',
        'semester',
        'file',
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
}
