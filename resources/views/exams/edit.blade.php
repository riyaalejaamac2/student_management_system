@extends('layouts.app')

@section('title', 'Edit Exam')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Exam Result</h4>
        <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary">Back to exams</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('exams.update', $exam) }}">
                @csrf
                @method('PUT')
                @include('exams.partials.form')
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Update Exam</button>
                </div>
            </form>
        </div>
    </div>
@endsection

