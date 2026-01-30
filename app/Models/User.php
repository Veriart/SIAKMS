<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\{Role, Subject, Student, Teacher};

class User extends Authenticatable
{
    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role_id) {
                $role = Role::find($user->role_id);
                if ($role) {
                    $user->syncRoles([$role->name]);
                }
            }
            if ($user->role_id == 2) {
                $teacher = Teacher::create([
                    'user_id' => $user->id,
                ]);
            }
        });

        static::updated(function ($user) {
            if ($user->wasChanged('role_id')) {
                $role = Role::find($user->role_id);
                if ($role) {
                    $user->syncRoles([$role->name]);
                }
            }
        });
    }
    use HasFactory, Notifiable, HasRoles;

    /**
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
