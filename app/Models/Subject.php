<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'grade',
        'teacher_id'
    ];

    /**
     * Get the teacher of the subject.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the class rooms of the subject.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classRooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClassSubject::class);
    }
}
