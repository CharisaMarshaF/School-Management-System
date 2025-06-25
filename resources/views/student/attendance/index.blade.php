@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <form method="GET" action="{{ route('student.attendance') }}" class="card p-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <input type="text" class="form-control" value="{{ $class_name ?? '' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Attendance Date</label>
                        <input type="date" name="attendance_date" class="form-control" value="{{ $filters['attendance_date'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Attendance Type</label>
                        <select name="attendance_type" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="1" {{ ($filters['attendance_type'] ?? '') == 1 ? 'selected' : '' }}>Present</option>
                            <option value="2" {{ ($filters['attendance_type'] ?? '') == 2 ? 'selected' : '' }}>Late</option>
                            <option value="3" {{ ($filters['attendance_type'] ?? '') == 3 ? 'selected' : '' }}>Excused Absence</option>
                            <option value="4" {{ ($filters['attendance_type'] ?? '') == 4 ? 'selected' : '' }}>Unexcused Absence</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-5">Search</button>
                        <a href="{{ route('student.attendance') }}" class="btn btn-success w-50">Reset</a>
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
                            <th>Class Name</th>
                            <th>Attendance Type</th>
                            <th>Attendance Date</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceData as $row)
                        <tr>
                            <td>{{ $class_name }}</td>
                            <td>
                                @php
                                    $types = [1 => 'Present', 2 => 'Late', 3 => 'Excused Absence', 4 => 'Unexcused Absence'];
                                @endphp
                                {{ $types[$row->attendance_type] ?? 'N/A' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($row->attendance_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y h:i A') }}</td>
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
