@extends('layouts.app')

@section('title', 'Add Exam')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Add Exam Result</h4>
        <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary">Back to exams</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('exams.store') }}">
                @csrf
                @include('exams.partials.form')
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">Save Exam</button>
                </div>
            </form>
        </div>
    </div>
@endsection

