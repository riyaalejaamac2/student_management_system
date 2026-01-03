@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Students Directory</h4>
            <small class="text-muted">Manage enrollment data, search, and paginate.</small>
        </div>
        @if (auth()->user()->canManageStudents())
            <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
        @endif
    </div>

    <form class="card border-0 shadow-sm mb-4" method="GET">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Name, email or phone">
            </div>
            <div class="col-md-4">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-select">
                    <option value="">All courses</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected(request('course_id') == $course->id)>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-primary w-100" type="submit">Apply filters</button>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Admission Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone ?? '—' }}</td>
                            <td>{{ $student->course?->name ?? 'Unassigned' }}</td>
                            <td>{{ optional($student->admission_date)->format('M d, Y') ?? '—' }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-outline-secondary">View</a>
                                    @if (auth()->user()->canManageStudents())
                                        <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary">Edit</a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this student?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $students->links() }}
        </div>
    </div>
@endsection

