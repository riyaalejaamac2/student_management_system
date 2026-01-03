@php
    $attendanceModel = $attendance ?? null;
@endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Student</label>
        <select name="student_id" class="form-select" required>
            <option value="">Choose student</option>
            @foreach ($students as $studentOption)
                <option value="{{ $studentOption->id }}"
                    @selected(old('student_id', $attendanceModel->student_id ?? '') == $studentOption->id)>
                    {{ $studentOption->name }} ({{ $studentOption->course?->name ?? 'No course' }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Date</label>
        <input type="date" name="date"
            value="{{ old('date', optional($attendanceModel?->date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
            class="form-control" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="">Select status</option>
            @foreach ($statuses as $option)
                <option value="{{ $option }}" @selected(old('status', $attendanceModel->status ?? '') === $option)>
                    {{ ucfirst($option) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="3" class="form-control"
            placeholder="Optional context...">{{ old('notes', $attendanceModel->notes ?? '') }}</textarea>
    </div>
</div>

