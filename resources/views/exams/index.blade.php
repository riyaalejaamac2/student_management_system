@extends('layouts.app')
@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Exams')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Exam Results</h4>
            <small class="text-muted">Track midterm, final, totals, and grades.</small>
        </div>

        @if (auth()->user()->canManageExams())
            <a href="{{ route('exams.create') }}" class="btn btn-primary">Add Exam</a>
        @endif
    </div>

    <form class="card border-0 shadow-sm mb-4" method="GET">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search student</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Name or email">
            </div>

            <div class="col-md-4">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-select">
                    <option value="">All courses</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected(request('course_id') == $course->id)>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-fill">Filter</button>
                <a href="{{ route('exams.index') }}" class="btn btn-light flex-fill">Reset</a>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th class="text-center">Midterm</th>
                        <th class="text-center">Final</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Grade</th>
                        <th>Notes</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($exams as $exam)
                        <tr>
                            <td>
                                <strong>{{ $exam->student?->name ?? 'Unknown' }}</strong><br>
                                <small class="text-muted">{{ $exam->student?->email }}</small>
                            </td>

                            <td>{{ $exam->course?->name ?? 'N/A' }}</td>

                            <td class="text-center">{{ number_format($exam->midterm_score, 2) }}</td>
                            <td class="text-center">{{ number_format($exam->final_score, 2) }}</td>
                            <td class="text-center fw-semibold">{{ number_format($exam->total_score, 2) }}</td>

                            <td class="text-center">
                                @php
                                    $badgeClass = match ($exam->grade) {
                                        'A' => 'bg-success',
                                        'B' => 'bg-primary',
                                        'C' => 'bg-info text-dark',
                                        'D' => 'bg-warning text-dark',
                                        default => 'bg-danger',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $exam->grade ?? '—' }}</span>
                            </td>

                            <td>{{ Str::limit($exam->notes, 40) ?: '—' }}</td>

                            <td class="text-end">
                                @if (auth()->user()->canManageExams())
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('exams.edit', $exam) }}" class="btn btn-outline-primary">Edit</a>

                                        <form action="{{ route('exams.destroy', $exam) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('Delete this exam record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">View only</span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No exam records yet.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="card-footer bg-white">
            {{ $exams->links() }}
        </div>
    </div>
@endsection
