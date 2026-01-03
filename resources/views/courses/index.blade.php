@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Courses')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Courses</h4>
            <small class="text-muted">Create and manage academic pathways.</small>
        </div>
        @if (auth()->user()->canManageCourses())
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Course
            </a>
        @endif
    </div>

    <form class="card border-0 shadow-sm mb-4" method="GET">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Course name">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">Search</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('courses.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Duration</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->duration ?? '—' }}</td>
                            <td>{{ Str::limit($course->description, 60) }}</td>
                            <td class="text-end">
                                @if(auth()->user()->canManageCourses())
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="text-muted">View only</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No courses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $courses->links() }}
        </div>
    </div>
@endsection

