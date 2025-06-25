@extends('layout.app')

@section('content')
<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">Attendance for: {{ $student->name }} {{ $student->last_name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Student Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <form method="GET" class="card p-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <input type="text" class="form-control" value="{{ $student->class->name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Attendance Date</label>
                        <input type="date" name="attendance_date" class="form-control" value="{{ request('attendance_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Attendance Type</label>
                        <select name="attendance_type" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="1" {{ request('attendance_type') == 1 ? 'selected' : '' }}>Present</option>
                            <option value="2" {{ request('attendance_type') == 2 ? 'selected' : '' }}>Late</option>
                            <option value="3" {{ request('attendance_type') == 3 ? 'selected' : '' }}>Excused Absence</option>
                            <option value="4" {{ request('attendance_type') == 4 ? 'selected' : '' }}>Unexcused Absence</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                        <a href="{{ route('parent.student.attendance.detail', $student->id) }}" class="btn btn-success w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card p-3">
            <h5>Attendance List</h5>
            <div class="table-responsive">
                <table class="table star-student table-hover table-center table-borderless table-striped">
                    <thead>
                        <tr>
                            <th>Attendance Date</th>
                            <th>Class Name</th>
                            <th>Attendance Type</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $types = [1 => 'Present', 2 => 'Late', 3 => 'Excused Absence', 4 => 'Unexcused Absence'];
                            $badgeColors = [1 => 'success', 2 => 'warning', 3 => 'info', 4 => 'danger'];
                        @endphp
                        @forelse($attendances as $att)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($att->attendance_date)->format('d-m-Y') }}</td>
                            <td>{{ $att->class->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $badgeColors[$att->attendance_type] ?? 'secondary' }}">
                                    {{ $types[$att->attendance_type] ?? 'Unknown' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($att->created_at)->format('d-m-Y h:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No attendance records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
