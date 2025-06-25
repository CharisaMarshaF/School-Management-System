@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                        <li class="breadcrumb-item active">Student Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <div class="card-header">
                <form>
                    <div class="row mb-3">
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
                        <div class="col-md-6">
                            <label>Date</label>
                            <input type="date" name="attendance_date" id="attendance_date" class="form-control"
                                value="{{ old('attendance_date', date('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div id="attendance-form-area" style="display: none;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover align-middle text-center attendance-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Student</th>
                                            <th>Present</th>
                                            <th>Late</th>
                                            <th>Excused Absence</th>
                                            <th>Unexcused Absence</th>
                                        </tr>
                                    </thead>
                                    <tbody id="student-list"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .radio-option {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .radio-option input[type="radio"] {
        display: none;
    }

    .radio-option label {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 6px 14px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        font-size: 18px;
    }

    .radio-option input[type="radio"]:checked + label {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    /* Buat semua kolom tabel memiliki lebar tetap */
    .attendance-table th,
    .attendance-table td {
        width: 20%;
        text-align: center;
        vertical-align: middle;
        padding: 12px;
        font-size: 16px;
    }

    .attendance-table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    /* Responsive styling */
    @media (max-width: 768px) {
        .radio-option label {
            font-size: 14px;
            padding: 5px 10px;
        }
    }
</style>

<script>
    const classSelect = document.getElementById('class_id');
    const dateInput = document.getElementById('attendance_date');
    const attendanceArea = document.getElementById('attendance-form-area');
    const studentList = document.getElementById('student-list');

    classSelect.addEventListener('change', fetchStudents);
    dateInput.addEventListener('change', fetchStudents);

    function fetchStudents() {
        const classId = classSelect.value;
        const date = dateInput.value;
        studentList.innerHTML = '';

        if (classId && date) {
            fetch(`{{ url('admin/student-attendance/get-students') }}/${classId}?date=${date}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        attendanceArea.style.display = 'block';
                        data.forEach(student => {
                            studentList.innerHTML += `
                                <tr>
                                    <td>
                                        ${student.name}
                                        <input type="hidden" name="student_id[]" value="${student.id}">
                                    </td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="present_${student.id}" name="attendance_type[${student.id}]" value="1" ${student.attendance_type == 1 ? 'checked' : ''} onchange="saveAttendance(${student.id}, 1)">
                                            <label for="present_${student.id}">✔</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="late_${student.id}" name="attendance_type[${student.id}]" value="2" ${student.attendance_type == 2 ? 'checked' : ''} onchange="saveAttendance(${student.id}, 2)">
                                            <label for="late_${student.id}">⏱</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="excused_${student.id}" name="attendance_type[${student.id}]" value="4" ${student.attendance_type == 4 ? 'checked' : ''} onchange="saveAttendance(${student.id}, 4)">
                                            <label for="excused_${student.id}">📝</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="absent_${student.id}" name="attendance_type[${student.id}]" value="3" ${student.attendance_type == 3 ? 'checked' : ''} onchange="saveAttendance(${student.id}, 3)">
                                            <label for="absent_${student.id}">❌</label>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        attendanceArea.style.display = 'none';
                    }
                });
        } else {
            attendanceArea.style.display = 'none';
        }
    }

    function saveAttendance(studentId, type) {
        const classId = classSelect.value;
        const date = dateInput.value;

        fetch(`{{ route('student.attendance.save.single') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    class_id: classId,
                    student_id: studentId,
                    attendance_type: type,
                    attendance_date: date,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(`Attendance saved for student ${studentId}`);
            })
            .catch(error => {
                alert('Failed to save attendance.');
                console.error(error);
            });
    }

    window.addEventListener('DOMContentLoaded', () => {
        @if(session('open_form'))
        fetchStudents();
        @endif
    });
</script>
@endsection
