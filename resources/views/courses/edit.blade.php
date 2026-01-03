@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Edit Course</h4>
        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('courses.update', $course) }}">
                @csrf
                @method('PUT')
                @include('courses.partials.form')
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </div>
            </form>
        </div>
    </div>
@endsection

