<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Only users who can manage exams (Admin + Exam user) may modify records.
        // All authenticated users may view the index.
        $this->middleware(function ($request, $next) {
            if (! auth()->user()->canManageExams() && ! $request->routeIs('exams.index')) {
                abort(403, 'Unauthorized action.');
            }

            return $next($request);
        })->except(['index']);
    }

    /**
     * Display a listing of the exams with search and filtering.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $courseId = $request->input('course_id');

        $exams = Exam::with(['student', 'course'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($courseId, fn ($query) => $query->where('course_id', $courseId))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('exams.index', [
            'exams' => $exams,
            'search' => $search,
            'courseId' => $courseId,
            'courses' => Course::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new exam record.
     */
    public function create(): View
    {
        return view('exams.create', [
            'exam' => new Exam(),
            'students' => Student::with('course')->orderBy('name')->get(),
            'courses' => Course::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created exam record.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $payload = $this->withTotalsAndGrades($data);

        Exam::create($payload);

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam record saved successfully.');
    }

    /**
     * Show the form for editing the specified exam.
     */
    public function edit(Exam $exam): View
    {
        return view('exams.edit', [
            'exam' => $exam,
            'students' => Student::with('course')->orderBy('name')->get(),
            'courses' => Course::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified exam record.
     */
    public function update(Request $request, Exam $exam): RedirectResponse
    {
        $data = $this->validatedData($request);
        $payload = $this->withTotalsAndGrades($data);

        $exam->update($payload);

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam record updated successfully.');
    }

    /**
     * Remove the specified exam record from storage.
     */
    public function destroy(Exam $exam): RedirectResponse
    {
        $exam->delete();

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam record deleted successfully.');
    }

    /**
     * Validate exam payloads.
     *
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'midterm_score' => ['required', 'numeric', 'between:0,100'],
            'final_score' => ['required', 'numeric', 'between:0,100'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    /**
     * Merge totals and grade into the validated payload.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function withTotalsAndGrades(array $data): array
    {
        $midterm = (float) $data['midterm_score'];
        $final = (float) $data['final_score'];
        $total = round($midterm + $final, 2);

        $data['total_score'] = $total;
        $data['grade'] = $this->calculateGrade($total);
        $data['status'] = $total >= 50 ? 'pass' : 'fail';

        return $data;
    }

    /**
     * Convert numeric totals into a letter grade.
     */
    private function calculateGrade(float $total): string
    {
        return match (true) {
            $total >= 90 => 'A',
            $total >= 80 => 'B',
            $total >= 70 => 'C',
            $total >= 60 => 'D',
            default => 'F',
        };
    }
}
