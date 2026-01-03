@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Attendance</h4>
        <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('attendance.update', $attendance) }}">
                @csrf
                @method('PUT')
                @include('attendance.partials.form')
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Update Attendance</button>
                </div>
            </form>
        </div>
    </div>
@endsection

