@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Add User</h4>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                @include('users.partials.form')
                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
@endsection

