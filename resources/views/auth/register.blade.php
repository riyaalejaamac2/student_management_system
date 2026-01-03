@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <div class="card border-0 shadow-lg">
        <div class="card-body p-4">
            <h3 class="mb-3 text-center">Create an account</h3>
            <p class="text-muted text-center mb-4">Register to manage the Students Management System.</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">Select role</option>
                        <option value="admin" @selected(old('role') === 'admin')>Administrator</option>
                        <option value="course_manager" @selected(old('role') === 'course_manager')>Course Manager</option>
                        <option value="staff" @selected(old('role') === 'staff')>Staff</option>
                        <option value="student" @selected(old('role') === 'student')>Student</option>
                        <option value="attendance" @selected(old('role') === 'attendance')>Attendance</option>
                        <option value="exam" @selected(old('role') === 'exam')>Exam</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="text-center mt-3 mb-0">
                <small class="text-muted">Already have an account? <a href="{{ route('login') }}">Sign in</a></small>
            </p>
        </div>
    </div>
@endsection

