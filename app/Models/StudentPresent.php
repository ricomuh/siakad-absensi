<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPresent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'subject_session_id',
    ];

    /**
     * Get the student that owns the student present.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the subject session that owns the student present.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subjectSession(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubjectSession::class);
    }
}
