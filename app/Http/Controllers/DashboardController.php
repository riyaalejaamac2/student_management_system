<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display dashboard statistics and quick insights.
     */
    public function index(): View
    {
        $counts = [
            'students' => Student::count(),
            'courses' => Course::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'attendance' => Attendance::count(),
            'exams' => Exam::count(),
        ];

        $attendanceStats = Attendance::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $recentStudents = Student::with('course')
            ->latest()
            ->take(5)
            ->get();

        $recentAttendance = Attendance::with('student')
            ->latest('date')
            ->take(5)
            ->get();

        $gradeStats = Exam::selectRaw('grade, COUNT(*) as total')
            ->groupBy('grade')
            ->orderBy('grade')
            ->pluck('total', 'grade');

        return view('dashboard', compact(
            'counts',
            'attendanceStats',
            'recentStudents',
            'recentAttendance',
            'gradeStats'
        ));
    }
}

