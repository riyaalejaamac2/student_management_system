<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Only users who can manage attendance (Admin + Attendance user) may modify records.
        // All authenticated users may view the index.
        $this->middleware(function ($request, $next) {
            if (! auth()->user()->canManageAttendance() && ! $request->routeIs('attendance.index')) {
                abort(403, 'Unauthorized action.');
            }

            return $next($request);
        })->except(['index']);
    }

    /**
     * Display attendance records with filtering options.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $attendance = Attendance::with('student.course')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderByDesc('date')
            ->paginate(10)
            ->withQueryString();

        return view('attendance.index', [
            'attendance' => $attendance,
            'search' => $search,
            'status' => $status,
            'statuses' => Attendance::STATUSES,
        ]);
    }

    /**
     * Show the form for marking attendance.
     */
    public function create(): View
    {
        return view('attendance.create', [
            'students' => Student::with('course')->orderBy('name')->get(),
            'statuses' => Attendance::STATUSES,
            'attendance' => new Attendance(),
        ]);
    }

    /**
     * Store a newly marked attendance record.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Attendance::create($data);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Show the form for editing an attendance record.
     */
    public function edit(Attendance $attendance): View
    {
        return view('attendance.edit', [
            'attendance' => $attendance,
            'students' => Student::with('course')->orderBy('name')->get(),
            'statuses' => Attendance::STATUSES,
        ]);
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $data = $this->validatedData($request);

        $attendance->update($data);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified attendance record.
     */
    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance deleted successfully.');
    }

    /**
     * Validate attendance payloads.
     *
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'status' => ['required', Rule::in(Attendance::STATUSES)],
            'notes' => ['nullable', 'string'],
        ]);
    }
}

