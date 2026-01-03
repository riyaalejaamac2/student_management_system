@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Add Student</h4>
        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('students.store') }}">
                @csrf
                @include('students.partials.form')
                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">Save Student</button>
                </div>
            </form>
        </div>
    </div>
@endsection

