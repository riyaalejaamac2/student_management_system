<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->canManageCourses() && !$request->routeIs('courses.index')) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        })->except(['index']);
    }

    /**
     * Display a listing of courses.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $courses = Course::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('courses.index', compact('courses', 'search'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(): View
    {
        return view('courses.create', [
            'course' => new Course(),
        ]);
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        Course::create($data);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course): View
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $this->validatedData($request, $course->id);

        $course->update($data);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Validate incoming course data.
     *
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?int $courseId = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses', 'name')->ignore($courseId),
            ],
            'duration' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);
    }
}

