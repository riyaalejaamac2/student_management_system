<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'course_id',
        'admission_date',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    /**
     * Course the student belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Attendance records made for the student.
     */
    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Exam records captured for the student.
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}

