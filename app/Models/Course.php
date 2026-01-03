<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'duration',
        'description',
    ];

    /**
     * Get the students enrolled in the course.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Exams associated with this course.
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}

