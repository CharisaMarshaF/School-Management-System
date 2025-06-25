@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">Exam Schedule</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                        <li class="breadcrumb-item active">Exam Schedule</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form di dalam card --}}
    <div class="row">
        <div class="card flex-fill comman-shadow">
            <div class="card-header">
                <form action="{{ route('exam.schedule.store') }}" method="POST">
                    @csrf
                    {{-- Exam + Class Select --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Exam</label>
                            <select name="exam_id" id="exam_id" class="form-control" required>
                                <option value="">Select Exam</option>
                                @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Class</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Subjects Table --}}
                    <div id="subject-form-area" style="display: none;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Exam Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Room</th>
                                    <th>Full Mark</th>
                                    <th>Passing Mark</th>
                                </tr>
                            </thead>
                            <tbody id="subject-list">
                                <!-- dynamically filled -->
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary mb-3">Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

{{-- JavaScript to handle dynamic subject fetching --}}
<script>
    document.getElementById('class_id').addEventListener('change', fetchSubjects);
    document.getElementById('exam_id').addEventListener('change', fetchSubjects);

    function fetchSubjects() {
        let classId = document.getElementById('class_id').value;
        let examId = document.getElementById('exam_id').value;
        let subjectArea = document.getElementById('subject-form-area');
        let tbody = document.getElementById('subject-list');
        tbody.innerHTML = '';

        if (classId && examId) {
            fetch(`{{ url('admin/get-subjects') }}/${classId}?exam_id=${examId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        subjectArea.style.display = 'block';
                        data.forEach((subject) => {
                            tbody.innerHTML += `
                                <tr>
                                    <td>
                                        ${subject.name}
                                        <input type="hidden" name="subject_id[]" value="${subject.id}">
                                    </td>
                                    <td><input type="date" name="exam_date[]" class="form-control" value="${subject.exam_date || ''}" ></td>
                                    <td><input type="time" name="start_time[]" class="form-control" value="${subject.start_time || ''}" ></td>
                                    <td><input type="time" name="end_time[]" class="form-control" value="${subject.end_time || ''}" ></td>
                                    <td><input type="text" name="room_number[]" class="form-control" value="${subject.room_number || ''}" ></td>
                                    <td><input type="number" name="full_marks[]" class="form-control" value="${subject.full_marks || ''}" ></td>
                                    <td><input type="number" name="passing_marks[]" class="form-control" value="${subject.passing_marks || ''}" ></td>
                                </tr>
                            `;
                        });
                    } else {
                        subjectArea.style.display = 'none';
                    }
                });
        } else {
            subjectArea.style.display = 'none';
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        let examId = document.getElementById('exam_id').value;
        let classId = document.getElementById('class_id').value;
        let subjectArea = document.getElementById('subject-form-area');

        // cek session open_form dari controller
        let openForm = {{ session('open_form') ? 'true' : 'false' }};

        if (openForm) {
            subjectArea.style.display = 'block';
            fetchSubjects();
        } else if (examId && classId) {
            fetchSubjects();
        } else {
            subjectArea.style.display = 'none';
        }
    });
</script>
@endsection
