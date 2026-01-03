<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use HasFactory;

    public const GRADE_SCALE = [
        90 => 'A',
        80 => 'B',
        70 => 'C',
        60 => 'D',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'midterm_score',
        'final_score',
        'total_score',
        'grade',
        'status',
        'notes',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'midterm_score' => 'float',
        'final_score' => 'float',
        'total_score' => 'float',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public static function determineGrade(float $totalScore): string
    {
        foreach (self::GRADE_SCALE as $threshold => $grade) {
            if ($totalScore >= $threshold) {
                return $grade;
            }
        }

        return 'F';
    }
}

