<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    public const STATUSES = [
        'present',
        'absent',
        'late',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'date',
        'status',
        'notes',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Student that owns the attendance record.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

