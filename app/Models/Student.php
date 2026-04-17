<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'identification_number',
        'classroom_id',
        'expertise_id',
        'academic_year_id',
        'gender',
        'religion',
        'exam_access',
        'slug',
    ];

    protected $casts = [
        'exam_access' => 'boolean',
    ];

    /**
     * Boot method to auto-generate slug on create/update.
     */
    protected static function booted(): void
    {
        static::creating(function (Student $student) {
            $student->slug = $student->generateSlug();
        });

        static::updating(function (Student $student) {
            if (empty($student->slug)) {
                $student->slug = $student->generateSlug();
            }
        });
    }

    /**
     * Generate a unique slug from identification_number + random string.
     */
    public function generateSlug(): string
    {
        $base = Str::slug($this->identification_number ?? Str::random(8));
        $slug = $base . '-' . Str::random(8);

        // Ensure uniqueness
        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $base . '-' . Str::random(8);
        }

        return $slug;
    }

    /**
     * Get route key name for slug-based routing.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
