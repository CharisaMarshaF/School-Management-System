<div class="mb-3">
    <label>Class</label>
    <select name="class_id" id="class_id" class="form-select" required onchange="fetchSubjects(null, false, '{{ $isEdit ? '#editHomeworkForm' : '' }}')">
        <option value="">Select Class</option>
        @foreach($classes as $class)
        <option value="{{ $class->id }}">{{ $class->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Subject</label>
    <select name="subject_id" id="subject_id" class="form-select" required>
        <option value="">Select Subject</option>
    </select>
</div>
<div class="mb-3">
    <label>Homework Date</label>
    <input type="date" name="homework_date" id="homework_date" class="form-control" required>
</div>
<div class="mb-3">
    <label>Submission Date</label>
    <input type="date" name="submission_date" id="submission_date" class="form-control" required>
</div>
<div class="mb-3">
    <label>Document File</label>
    <input type="file" name="document_file" class="form-control">
</div>
<div class="mb-3">
    <label>Description</label>
    <textarea name="description" id="description" class="form-control" required></textarea>
</div>
