<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_subject_id',
        'schedule_id',
        'uuid',
        'closed_at'
    ];

    // cast the closed_at attribute to a datetime object
    protected $casts = [
        'closed_at' => 'datetime'
    ];

    /**
     * Get the class subject that owns the subject session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class);
    }

    /**
     * Get the schedule that owns the subject session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the student presents for the subject session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentPresents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StudentPresent::class, 'subject_session_id');
    }
}
