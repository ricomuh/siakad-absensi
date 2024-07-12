<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'class_room_id'
    ];

    /**
     * Get the student of the class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the class room of the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classRoom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }
}
