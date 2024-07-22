<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // admins scope
    public function scopeAdmins($query)
    {
        return $query->where('role_id', RoleEnum::ADMIN);
    }

    // teachers scope
    public function scopeTeachers($query)
    {
        return $query->where('role_id', RoleEnum::TEACHER);
    }

    // students scope
    public function scopeStudents($query)
    {
        return $query->where('role_id', RoleEnum::STUDENT);
    }

    /**
     * Get the role of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // get the role name
    public function getRoleNameAttribute()
    {
        return $this->role->name;
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role->name === RoleEnum::ADMIN;
    }

    /**
     * Check if the user is a teacher.
     *
     * @return bool
     */
    public function isTeacher(): bool
    {
        return $this->role->name === RoleEnum::TEACHER;
    }

    /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->role->name === RoleEnum::STUDENT;
    }

    /**
     * Get the classrooms that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classRooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentClass::class, 'student_id');
    }

    /**
     * Get only one classroom that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function classRoom(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(StudentClass::class, 'student_id');
    }
}
