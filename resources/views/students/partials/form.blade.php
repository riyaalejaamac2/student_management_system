@php
    $studentModel = $student ?? null;
@endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" value="{{ old('name', $studentModel->name ?? '') }}" class="form-control"
            required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" value="{{ old('email', $studentModel->email ?? '') }}" class="form-control"
            required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Phone Number</label>
        <input type="text" name="phone" value="{{ old('phone', $studentModel->phone ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option value="">Select gender</option>
            @foreach (['Male', 'Female', 'Other'] as $gender)
                <option value="{{ $gender }}" @selected(old('gender', $studentModel->gender ?? '') === $gender)>
                    {{ $gender }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($studentModel?->date_of_birth)->format('Y-m-d') ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Admission Date</label>
        <input type="date" name="admission_date" value="{{ old('admission_date', optional($studentModel?->admission_date)->format('Y-m-d') ?? '') }}" class="form-control">
    </div>
    <div class="col-md-12">
        <label class="form-label">Course</label>
        <select name="course_id" class="form-select">
            <option value="">Select course</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" @selected(old('course_id', $studentModel->course_id ?? '') == $course->id)>{{ $course->name }}</option>
            @endforeach
        </select>
    </div>
</div>

