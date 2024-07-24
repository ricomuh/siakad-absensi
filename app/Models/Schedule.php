<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_subject_id',
        'day',
        'start_time',
        'end_time',
    ];

    /**
     * Get the class subject that owns the schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class);
    }

    /**
     * Get the subject that owns the schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the schedule's day.
     *
     * @return string
     */
    public function getDayNameAttribute(): string
    {
        // $days = [
        //     0 => 'Sunday',
        //     1 => 'Monday',
        //     2 => 'Tuesday',
        //     3 => 'Wednesday',
        //     4 => 'Thursday',
        //     5 => 'Friday',
        //     6 => 'Saturday',
        // ];
        $days = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];

        return $days[$this->attributes['day']];
    }

    /**
     * Get the schedule's sessions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubjectSession::class);
    }

    /**
     * Get the schedule's only one session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function session(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SubjectSession::class);
    }
}
