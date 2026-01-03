<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Only users who can manage students (Admin + Staff) may modify records.
        // Everyone authenticated may view index/show.
        $this->middleware(function ($request, $next) {
            if (! auth()->user()->canManageStudents() && ! $request->routeIs('students.index', 'students.show')) {
                abort(403, 'Unauthorized action.');
            }

            return $next($request);
        })->except(['index', 'show']);
    }

    /**
     * Display a listing of students with optional filtering.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $courseId = $request->input('course_id');

        $students = Student::with('course')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($courseId, fn ($query) => $query->where('course_id', $courseId))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $courses = Course::orderBy('name')->get();

        return view('students.index', compact('students', 'courses', 'search', 'courseId'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): View
    {
        $courses = Course::orderBy('name')->get();

        return view('students.create', [
            'courses' => $courses,
            'student' => new Student(),
        ]);
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Student::create($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student): View
    {
        $student->load('course');
        $attendance = $student->attendanceRecords()->latest('date')->paginate(10);
        $exams = $student->exams()->with('course')->latest()->get();

        return view('students.show', compact('student', 'attendance', 'exams'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student): View
    {
        $courses = Course::orderBy('name')->get();

        return view('students.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $data = $this->validatedData($request, $student->id);

        $student->update($data);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student removed successfully.');
    }

    /**
     * Build the validation array for student operations.
     *
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?int $studentId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($studentId),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'admission_date' => ['nullable', 'date'],
        ]);
    }
}

