@php
    $courseModel = $course ?? null;
@endphp
<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $courseModel->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Duration</label>
    <input type="text" name="duration" class="form-control" value="{{ old('duration', $courseModel->duration ?? '') }}"
        placeholder="e.g. 3 Years">
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4"
        placeholder="Overview of the course">{{ old('description', $courseModel->description ?? '') }}</textarea>
</div>

