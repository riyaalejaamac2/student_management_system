<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Determine if the current user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Determine if the current user is staff.
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Determine if the current user is a course manager.
     */
    public function isCourseManager(): bool
    {
        return $this->role === 'course_manager';
    }

    /**
     * Determine if the current user can manage courses.
     */
    public function canManageCourses(): bool
    {
        return $this->isAdmin() || $this->isCourseManager();
    }

    /**
     * Determine if the current user can manage students.
     *
     * Admin, Staff and Student-user roles can manage student records.
     * Student-user is restricted to student-related data only by controller logic.
     */
    public function canManageStudents(): bool
    {
        return $this->isAdmin() || $this->isStaff() || $this->role === 'student';
    }

    /**
     * Determine if the current user is an exam user.
     */
    public function isExamUser(): bool
    {
        return $this->role === 'exam';
    }

    /**
     * Determine if the current user can manage exams.
     *
     * Admin and Exam users can manage exam records.
     */
    public function canManageExams(): bool
    {
        return $this->isAdmin() || $this->isExamUser();
    }

    /**
     * Determine if the current user is an attendance user.
     */
    public function isAttendanceUser(): bool
    {
        return $this->role === 'attendance';
    }

    /**
     * Determine if the current user can manage attendance.
     *
     * Admin and Attendance users can manage attendance records.
     * Staff can only view.
     */
    public function canManageAttendance(): bool
    {
        return $this->isAdmin() || $this->isAttendanceUser();
    }
}
