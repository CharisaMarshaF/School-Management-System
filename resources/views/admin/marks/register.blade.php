@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title ?? 'Marks Register' }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Marks Register</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER EXAM & CLASS --}}
    <form method="GET" action="{{ route('marks.register.index') }}">
        <div class="row mb-4">
            <div class="col-md-4">
                <label>Exam</label>
                <select name="exam_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Select Exam --</option>
                    @foreach($exams as $exam)
                    <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
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
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- FORM NILAI --}}
    @if(count($students) && count($schedules))
    @foreach($students as $student)
    <form action="{{ route('marks.register.save') }}" method="POST" class="mb-5 p-4 border rounded bg-light">
        @csrf
        <input type="hidden" name="exam_id" value="{{ $exam_id }}">
        <input type="hidden" name="class_id" value="{{ $class_id }}">
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <h5 class="mb-3 text-primary">{{ $student->name }}</h5>
        <div class="row">
            @foreach($schedules as $subject)
            @php
            $inputPrefix = "marks[{$subject->subject_id}]";
            $mark = $marks[$student->id . '_' . $subject->subject_id] ?? null;

            $class_work = $mark->class_work ?? 0;
            $home_work = $mark->home_work ?? 0;
            $test_work = $mark->test_work ?? 0;
            $exam_mark = $mark->exam ?? 0;

            $total_mark = $class_work + $home_work + $test_work + $exam_mark;
            $full_marks = $subject->full_marks ?? 100;
            $percent = $full_marks > 0 ? round(($total_mark / $full_marks) * 100) : 0;

            $grade = $gradesByMark[$student->id . '_' . $subject->subject_id] ?? '-';

            $is_pass = $total_mark >= $subject->passing_marks;
            @endphp

            <div class="col-md-6 mb-4">
                <div class="border p-3 rounded shadow-sm bg-white">
                    <h6 class="text-dark fw-bold mb-3">
                        {{ $subject->subject->name }} ({{ $subject->subject->type }})
                        <span class="text-muted">[Full: {{ $full_marks }}, Passing:
                            {{ $subject->passing_marks }}]</span>
                    </h6>

                    {{-- Input nilai --}}
                    <div class="form-group mb-2">
                        <label>Class Work</label>
                        <input type="number" class="form-control" name="{{ $inputPrefix }}[class_work]"
                            value="{{ old("marks.{$subject->subject_id}.class_work", $class_work) }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Home Work</label>
                        <input type="number" class="form-control" name="{{ $inputPrefix }}[home_work]"
                            value="{{ old("marks.{$subject->subject_id}.home_work", $home_work) }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Test Work</label>
                        <input type="number" class="form-control" name="{{ $inputPrefix }}[test_work]"
                            value="{{ old("marks.{$subject->subject_id}.test_work", $test_work) }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Exam</label>
                        <input type="number" class="form-control" name="{{ $inputPrefix }}[exam]"
                            value="{{ old("marks.{$subject->subject_id}.exam", $exam_mark) }}" required>
                    </div>

                    {{-- Info total, persen dan grade --}}
                    <div class="mt-2 fw-bold text-{{ $is_pass ? 'success' : 'danger' }} total-mark-info"
                        data-full="{{ $full_marks }}" data-passing="{{ $subject->passing_marks }}">
                        Total Marks: {{ $total_mark }} /
                        {{ $full_marks }} - {{ $is_pass ? 'PASS' : 'FAIL' }} <br>
                        Percent: {{ $percent }}% <br>
                        Grade: {{ $grade }}
                    </div>

                    <button type="button" class="btn btn-sm btn-primary mt-3 w-100" onclick="submitSingleSubject(this, '{{ route('marks.register.subject.save') }}',
                        {{ $student->id }}, {{ $subject->subject_id }})">
                        Save Subject
                    </button>
                </div>
            </div>
            @endforeach

        </div>

        <button type="submit" class="btn btn-success mt-2">Save All for {{ $student->name }}</button>
    </form>
    @endforeach
    @elseif(request()->has('exam_id') && request()->has('class_id'))
    <div class="alert alert-warning">No students or schedule found for the selected class and exam.</div>
    @endif
</div>
</div>

{{-- JS UNTUK SUBMIT SEMUA MARKS --}}

{{-- JS UNTUK SUBMIT PER SUBJECT --}}
<script>
    function submitSingleSubject(button, url, student_id, subject_id) {
        const container = button.closest('.border');

        const classWork = parseFloat(container.querySelector(`input[name="marks[${subject_id}][class_work]"]`).value) ||
            0;
        const homeWork = parseFloat(container.querySelector(`input[name="marks[${subject_id}][home_work]"]`).value) ||
        0;
        const testWork = parseFloat(container.querySelector(`input[name="marks[${subject_id}][test_work]"]`).value) ||
        0;
        const exam = parseFloat(container.querySelector(`input[name="marks[${subject_id}][exam]"]`).value) || 0;

        const total = classWork + homeWork + testWork + exam;

        const infoElement = container.querySelector('.total-mark-info');
        const fullMark = parseFloat(infoElement.dataset.full) || 0;
        const passingMark = parseFloat(infoElement.dataset.passing) || 0;
        const isPass = total >= passingMark;

        const formData = new FormData();
        formData.append('student_id', student_id);
        formData.append('class_id', '{{ $class_id }}');
        formData.append('exam_id', '{{ $exam_id }}');
        formData.append('subject_id', subject_id);
        formData.append('class_work', classWork);
        formData.append('home_work', homeWork);
        formData.append('test_work', testWork);
        formData.append('exam', exam);
        formData.append('_token', '{{ csrf_token() }}');

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                response.json().then(data => {
                    // Update hasil di UI
                    // Untuk grade, kita harus kirim dari backend atau hitung manual di JS
                    // Sementara hitung grade di JS dengan data grades dari blade (bisa dilempar JSON)
                    const grades = @json($grades);

                    let percent = fullMark > 0 ? Math.round((total / fullMark) * 100) : 0;
                    let gradeName = '-';
                    for (let g of grades) {
                        if (percent >= g.percent_from && percent <= g.percent_to) {
                            gradeName = g.name;
                            break;
                        }
                    }

                    infoElement.innerHTML = `Total Marks: ${total} / ${fullMark} - ${isPass ? 'PASS' : 'FAIL'} <br>
                                         Percent: ${percent}% <br>
                                         Grade: ${gradeName}`;
                    infoElement.className =
                        `mt-2 fw-bold text-${isPass ? 'success' : 'danger'} total-mark-info`;

                    alert('Subject marks saved!');
                });
            } else {
                alert('Failed to save subject marks.');
            }
        }).catch(() => {
            alert('Error occurred while saving marks.');
        });
    }
</script>
@endsection
