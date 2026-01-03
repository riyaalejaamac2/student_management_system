@php
    $examModel = $exam ?? null;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Student Name</label>
        <select name="student_id" class="form-select" required>
            <option value="">Choose student</option>
            @foreach ($students as $studentOption)
                <option value="{{ $studentOption->id }}"
                    @selected(old('student_id', $examModel->student_id ?? '') == $studentOption->id)>
                    {{ $studentOption->name }} ({{ $studentOption->course?->name ?? 'No course' }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Course</label>
        <select name="course_id" class="form-select">
            <option value="">Select course</option>
            @foreach ($courses as $courseOption)
                <option value="{{ $courseOption->id }}"
                    @selected(old('course_id', $examModel->course_id ?? '') == $courseOption->id)>
                    {{ $courseOption->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Midterm</label>
        <input type="number" step="0.5" min="0" max="100" name="midterm_score"
            value="{{ old('midterm_score', $examModel->midterm_score ?? '') }}" class="form-control score-input" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Final</label>
        <input type="number" step="0.5" min="0" max="100" name="final_score"
            value="{{ old('final_score', $examModel->final_score ?? '') }}" class="form-control score-input" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Total</label>
        <input type="text" class="form-control" id="exam-total-display"
            value="{{ old('total_score', $examModel->total_score ?? 'Calculated on save') }}" readonly>
    </div>
    <div class="col-md-6">
        <label class="form-label">Grade</label>
        <input type="text" class="form-control" id="exam-grade-display"
            value="{{ old('grade', $examModel->grade ?? 'Calculated on save') }}" readonly>
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="3" class="form-control" placeholder="Optional comments...">{{ old('notes', $examModel->notes ?? '') }}</textarea>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const midtermInput = document.querySelector('input[name="midterm_score"]');
            const finalInput = document.querySelector('input[name="final_score"]');
            const totalDisplay = document.getElementById('exam-total-display');
            const gradeDisplay = document.getElementById('exam-grade-display');

            const gradeScale = [
                { min: 90, letter: 'A' },
                { min: 80, letter: 'B' },
                { min: 70, letter: 'C' },
                { min: 60, letter: 'D' },
            ];

            const updateSummary = () => {
                const midterm = parseFloat(midtermInput.value) || 0;
                const final = parseFloat(finalInput.value) || 0;
                const total = Math.round((midterm + final) * 100) / 100;

                totalDisplay.value = total > 0 ? total : 'Calculated on save';

                const grade = gradeScale.find((scale) => total >= scale.min)?.letter ?? (total > 0 ? 'F' : 'Calculated on save');
                gradeDisplay.value = grade;
            };

            midtermInput?.addEventListener('input', updateSummary);
            finalInput?.addEventListener('input', updateSummary);
            updateSummary();
        });
    </script>
@endpush
