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
}
