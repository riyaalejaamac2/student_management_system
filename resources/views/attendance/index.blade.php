@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Attendance</h4>
            <small class="text-muted">Search by student or status, paginate results.</small>
        </div>
        @if (auth()->user()->canManageAttendance())
            <a href="{{ route('attendance.create') }}" class="btn btn-primary">Mark Attendance</a>
        @endif
    </div>

    <form class="card border-0 shadow-sm mb-4" method="GET">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search student</label>
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Name or email">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $option)
                        <option value="{{ $option }}" @selected(request('status') === $option)>{{ ucfirst($option) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('attendance.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendance as $record)
                        <tr>
                            <td>
                                <strong>{{ $record->student?->name ?? 'Unknown' }}</strong><br>
                                <small class="text-muted">{{ $record->student?->course?->name ?? 'No course' }}</small>
                            </td>
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
                            <td class="text-end">
                                @if (auth()->user()->canManageAttendance())
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('attendance.edit', $record) }}" class="btn btn-outline-primary">Edit</a>
                                        <form action="{{ route('attendance.destroy', $record) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this record?')">
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
                            <td colspan="5" class="text-center text-muted py-4">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $attendance->links() }}
        </div>
    </div>
@endsection

