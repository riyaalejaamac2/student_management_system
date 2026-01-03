@php
    $userModel = $user ?? null;
@endphp
<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $userModel->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $userModel->email ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-select" required>
        <option value="">Select role</option>
        @foreach ([
            'admin' => 'Administrator', 
            'course_manager' => 'Course Manager',
            'staff' => 'Staff',
            'student' => 'Student',
            'attendance' => 'Attendance',
            'exam' => 'Exam',
        ] as $value => $label)
            <option value="{{ $value }}" @selected(old('role', $userModel->role ?? '') === $value)>{{ $label }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" {{ isset($userModel) ? '' : 'required' }}>
    <small class="text-muted">{{ isset($userModel) ? 'Leave blank to keep current password.' : 'Minimum 8 characters.' }}</small>
</div>
<div class="mb-3">
    <label class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control" {{ isset($userModel) ? '' : 'required' }}>
</div>

