@php
    $isEdit = isset($edit);
@endphp

<div class="mb-3">
    <label>Class</label>
    <select name="class_id" class="form-select" required>
        <option value="">-- Select Class --</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" {{ $isEdit && $edit->class_id == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Subject</label>
    <select name="subject_id" class="form-select" required>
        @if($isEdit)
            <option value="{{ $edit->subject_id }}">{{ $edit->subject->name ?? '' }}</option>
        @else
            <option value="">-- Select Subject --</option>
        @endif
    </select>
</div>

<div class="mb-3">
    <label>Homework Date</label>
    <input type="date" name="homework_date" class="form-control" value="{{ $edit->homework_date ?? '' }}" required>
</div>

<div class="mb-3">
    <label>Submission Date</label>
    <input type="date" name="submission_date" class="form-control" value="{{ $edit->submission_date ?? '' }}" required>
</div>

<div class="mb-3">
    <label>Document File</label>
    <input type="file" name="document_file" class="form-control">
    @if($isEdit && $edit->document_file)
        <small class="text-muted">Existing file: <a href="{{ asset('storage/'.$edit->document_file) }}" target="_blank">Download</a></small>
    @endif
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ $edit->description ?? '' }}</textarea>
</div>
