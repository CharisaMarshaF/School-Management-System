@extends('layout.app')
@section('title', $header_title)

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Teacher</li>
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
                            <label>Kelas</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Tanggal</label>
                            <input type="date" name="attendance_date" id="attendance_date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
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

    .attendance-table th,
    .attendance-table td {
        width: 20%;
        text-align: center;
        vertical-align: middle;
        padding: 12px;
        font-size: 16px;
    }

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
            fetch(`{{ url('teacher/student-attendance/get-students') }}/${classId}?date=${date}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        attendanceArea.style.display = 'block';
                        data.forEach(student => {
                            studentList.innerHTML += `
                                <tr>
                                    <td>${student.name} ${student.last_name}</td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="present_${student.id}" name="attendance_type[${student.id}]" value="1" ${student.attendance_type == 1 ? 'checked' : ''} onchange="saveAttendance(${classId}, ${student.id}, 1, '${date}')">
                                            <label for="present_${student.id}">✔</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="late_${student.id}" name="attendance_type[${student.id}]" value="2" ${student.attendance_type == 2 ? 'checked' : ''} onchange="saveAttendance(${classId}, ${student.id}, 2, '${date}')">
                                            <label for="late_${student.id}">⏱</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="absent_${student.id}" name="attendance_type[${student.id}]" value="3" ${student.attendance_type == 3 ? 'checked' : ''} onchange="saveAttendance(${classId}, ${student.id}, 3, '${date}')">
                                            <label for="absent_${student.id}">📝</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-option">
                                            <input type="radio" id="half_${student.id}" name="attendance_type[${student.id}]" value="4" ${student.attendance_type == 4 ? 'checked' : ''} onchange="saveAttendance(${classId}, ${student.id}, 4, '${date}')">
                                            <label for="half_${student.id}">❌</label>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        attendanceArea.style.display = 'none';
                        studentList.innerHTML = '<tr><td colspan="5">Tidak ada siswa ditemukan.</td></tr>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data siswa.');
                });
        }
    }

    function saveAttendance(class_id, student_id, attendance_type, attendance_date) {
        fetch(`{{ route('student.attendance.save.single') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                class_id: class_id,
                student_id: student_id,
                attendance_type: attendance_type,
                attendance_date: attendance_date
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert('Gagal menyimpan kehadiran.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    }
</script>
@endsection
