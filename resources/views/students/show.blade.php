@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">{{ $student->name }}</h4>
            <small class="text-muted">Profile overview & attendance summary</small>
        </div>
        <div class="d-flex gap-2">
            @if (auth()->user()->isAdmin())
                <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-primary">Edit</a>
            @endif
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to list</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-3">Student Information</h5>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $student->email }}</dd>

                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8">{{ $student->phone ?? '—' }}</dd>

                        <dt class="col-sm-4">Gender</dt>
                        <dd class="col-sm-8">{{ $student->gender ?? '—' }}</dd>

                        <dt class="col-sm-4">DOB</dt>
                        <dd class="col-sm-8">{{ optional($student->date_of_birth)->format('M d, Y') ?? '—' }}</dd>

                        <dt class="col-sm-4">Admission</dt>
                        <dd class="col-sm-8">{{ optional($student->admission_date)->format('M d, Y') ?? '—' }}</dd>

                        <dt class="col-sm-4">Course</dt>
                        <dd class="col-sm-8">{{ $student->course?->name ?? 'Unassigned' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-3">Attendance Snapshot</h5>
                    @php
                        $totals = $student->attendanceRecords
                            ->groupBy('status')
                            ->map->count();
                    @endphp
                    @forelse ($totals as $status => $total)
                        @php
                            $badgeClass = match ($status) {
                                'present' => 'bg-success',
                                'late' => 'bg-warning text-dark',
                                default => 'bg-danger',
                            };
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge {{ $badgeClass }} text-uppercase">{{ $status }}</span>
                            <span>{{ $total }} day(s)</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No attendance records captured for this student.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Attendance History</h5>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('attendance.create') }}" class="btn btn-sm btn-outline-primary">Mark attendance</a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendance as $record)
                            <tr>
                                <td>{{ optional($record->date)->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $badgeClass = match ($record->status) {
                                            'present' => 'bg-success',
                                            'late' => 'bg-warning text-dark',
                                            default => 'bg-danger',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} text-uppercase">{{ $record->status }}</span>
                                </td>
                                <td>{{ $record->notes ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">No attendance records.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $attendance->links() }}
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Exam Results</h5>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('exams.create') }}" class="btn btn-sm btn-outline-success">Add exam</a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th class="text-center">Mid Term</th>
                            <th class="text-center">Final</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($exams as $exam)
                            <tr>
                                <td>{{ $exam->course?->name ?? $student->course?->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ number_format($exam->midterm_score, 1) }}</td>
                                <td class="text-center">{{ number_format($exam->final_score, 1) }}</td>
                                <td class="text-center fw-semibold">{{ number_format($exam->total_score, 1) }}</td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = match ($exam->grade) {
                                            'A', 'B' => 'bg-success',
                                            'C', 'D' => 'bg-warning text-dark',
                                            default => 'bg-danger',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $exam->grade }}</span>
                                </td>
                                <td>{{ $exam->remarks ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No exams recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

