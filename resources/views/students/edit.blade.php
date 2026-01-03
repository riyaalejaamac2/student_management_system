@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Student</h4>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('students.update', $student) }}">
                @csrf
                @method('PUT')
                @include('students.partials.form')
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('students.show', $student) }}" class="btn btn-light">View Profile</a>
                    <button type="submit" class="btn btn-primary">Update Student</button>
                </div>
            </form>
        </div>
    </div>
@endsection

