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
                        <li class="breadcrumb-item active">Admin</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <form method="GET" action="{{ route('student.attendance.report') }}" class="card p-3 mb-4">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" name="student_id" class="form-control" placeholder="Student ID"
                            value="{{ $request->student_id }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="student_name" class="form-control" placeholder="Student Name"
                            value="{{ $request->student_name }}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="student_last_name" class="form-control" placeholder="Student Last Name"
                            value="{{ $request->student_last_name }}">
                    </div>
                    <div class="col-md-2">
                        <select name="class_id" class="form-control">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $request->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="attendance_date" class="form-control"
                            value="{{ $request->attendance_date }}">
                    </div>
                    <div class="col-md-2">
                        <select name="attendance_type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1" {{ $request->attendance_type === '1' ? 'selected' : '' }}>Present</option>
                            <option value="2" {{ $request->attendance_type === '2' ? 'selected' : '' }}>Late</option>
                            <option value="3" {{ $request->attendance_type === '3' ? 'selected' : '' }}>Excused Absence
                            </option>
                            <option value="4" {{ $request->attendance_type === '4' ? 'selected' : '' }}>Unexcused
                                Absence</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('student.attendance.report') }}" class="btn btn-success">Reset</a>
                </div>
            </form>
        </div>
            <div class="card p-3">
                <h5>Attendance List</h5>

                <div class="table-responsive">

                    <table class="table star-student table-hover table-center table-borderless table-striped">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Class Name</th>
                                <th>Attendance Type</th>
                                <th>Attendance Date</th>
                                <th>Created By</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $row)
                            <tr>
                                <td>{{ $row->student_id }}</td>
                                <td>{{ $row->student->name ?? '' }} {{ $row->student->last_name ?? '' }}</td>
                                <td>{{ $row->class->name ?? '' }}</td>
                                <td>
                                    @php
                                    $types = [1 => 'Present', 2 => 'Late', 3 => 'Excused Absence', 4 => 'Unexcused Absence'];
                                    @endphp
                                    {{ $types[$row->attendance_type] ?? '' }}
                                </td>
                                <td>{{ date('d-m-Y', strtotime($row->attendance_date)) }}</td>
                                <td>{{ $row->creator->name ?? '' }}</td>
                                <td>{{ date('d-m-Y h:i A', strtotime($row->created_at)) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
            @endsection
