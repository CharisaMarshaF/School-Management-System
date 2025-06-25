@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">My Students</h4>

    <div class="card">
        <div class="card-header">
            Assigned Students
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-center table-borderless table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Class</th>
                            <th>Admission No</th>
                            <th>Roll No</th>
                            <th>Religion</th>
                            <th>Mobile</th>
                            <th>Admission Date</th>
                            <th>Address</th>
                            <th>Blood Group</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <td>
                                @if($student->profile_pic)
                                    <img src="{{ asset('SchoolMS_App/public/uploads/students/'.$student->profile_pic) }}"
                                         width="50" height="50" class="rounded-circle" alt="Profile">
                                @else
                                    <span class="text-muted">No Photo</span>
                                @endif
                            </td>
                            <td>{{ $student->name }} {{ $student->last_name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->date_of_birth }}</td>
                            <td>{{ $student->class->name ?? '-' }}</td>
                            <td>{{ $student->admission_number }}</td>
                            <td>{{ $student->role_number }}</td>
                            <td>{{ $student->religion }}</td>
                            <td>{{ $student->mobile_number }}</td>
                            <td>{{ $student->admission_date }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->blood_group }}</td>
                            <td>{{ $student->height }}</td>
                            <td>{{ $student->weight }}</td>
                            <td class="text-center">
                                <a href="{{ route('parent.student.subjects', $student->id) }}" class="btn btn-sm btn-primary">
                                    Subjects
                                </a>
                                <a href="{{ route('parent.student.exam.timetable', $student->id) }}" class="btn btn-sm btn-info">
                                    Exam Timetable
                                </a>
                                <a href="{{ route('parent.exam_result', $student->id) }}" class="btn btn-sm btn-secondary">
                                    Exam Result
                                </a>
                                <a href="{{ route('parent.student.calendar', $student->id) }}" class="btn btn-sm btn-success">
                                    Calendar
                                </a>
                                <a href="{{ route('parent.student.attendance.detail', $student->id) }}" class="btn btn-sm btn-secondary">
                                    Attendance
                                </a>
                               <a href="{{ route('parent.student.homework', $student->id) }}" class="btn btn-sm btn-warning">
                                    Homework
                                </a>
                                <a href="{{ route('parent.student.homework.submitted', $student->id) }}" class="btn btn-sm btn-success">
                                    Submitted Homework
                                </a>
                                <a href="{{ route('parent.student.fees', $student->id) }}" class="btn btn-sm btn-info">
                                    Fees
                                </a>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="16" class="text-center">No students assigned</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
