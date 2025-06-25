@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <h3 class="page-title mb-4">Teacher Marks Register</h3>

    <form method="GET" action="{{ route('teacher.marks.register.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label>Exam</label>
                <select name="exam_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Select Exam --</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ (int)request('exam_id')=== $exam->id ? 'selected':'' }}>
                            {{ $exam->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Class</label>
                <select name="class_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Select Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ (int)request('class_id')=== $class->id ? 'selected':'' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    @if($students->isEmpty() || $schedules->isEmpty())
        <div class="alert alert-warning">No students or schedule found.</div>
    @else
        @foreach($students as $student)
            {{-- reuse blade form dari admin namun action route teacher --}}
@include('teacher.marks.partials_form', ['student'=>$student, 'gradesByMark' => $gradesByMark])
        @endforeach
    @endif
</div>

<script>
function submitSingleSubject(button, url, student_id, subject_id){
    const container = button.closest('.border');
    const getVal = name => parseFloat(container.querySelector(`input[name="marks[${subject_id}][${name}]"]`).value) || 0;
    const [cw, hw, tw, ex] = ['class_work','home_work','test_work','exam'].map(getVal);
    const total = cw + hw + tw + ex;

    const info = container.querySelector('.total-mark-info');
    const full = +info.dataset.full;
    const passMark = +info.dataset.passing;
    const passed = total >= passMark;

    const data = new FormData();
    data.append('student_id', student_id); // ✅ pakai parameter JS, bukan Blade
    data.append('class_id', '{{ $class_id }}');
    data.append('exam_id', '{{ $exam_id }}');
    data.append('subject_id', subject_id);
    data.append('class_work', cw);
    data.append('home_work', hw);
    data.append('test_work', tw);
    data.append('exam', ex);
    data.append('_token', '{{ csrf_token() }}');

    fetch(url, { method: 'POST', body: data })
        .then(r => r.ok ? (function() {
            info.textContent = `Total Marks: ${total} / ${full} - ${passed ? 'PASS' : 'FAIL'}`;
            info.className = `mt-2 fw-bold text-${passed ? 'success' : 'danger'} total-mark-info`;
            alert("Marks Saved");
        })() : alert("Error"))
        .catch(() => alert("Network error"));
}


</script>
@endsection
