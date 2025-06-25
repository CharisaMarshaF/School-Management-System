@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student Homework Report</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
<form method="GET" action="{{ route('admin.homework.report') }}" class="row mb-4">
    <div class="col-md-3">
        <label>Class</label>
        <select name="class_id" class="form-control">
            <option value="">All Class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label>Subject</label>
        <select name="subject_id" class="form-control">
            <option value="">All Subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label>Student Name</label>
        <input type="text" name="student_name" class="form-control" placeholder="Search by student name" value="{{ request('student_name') }}">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2 w-50">🔍 Search</button>
        <a href="{{ route('admin.homework.report') }}" class="btn btn-secondary w-50">⟲ Reset</a>
    </div>
</form>


    {{-- Table --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Homework Date</th>
                        <th>Submission Date</th>
                        <th>Homework Description</th>
                        <th>Homework File</th>
                        <th>Submitted Description</th>
                        <th>Submitted File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $index => $submit)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $submit->student->name ?? '-' }}</td>
                            <td>{{ $submit->homework->class->name ?? '-' }}</td>
                            <td>{{ $submit->homework->subject->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($submit->homework->homework_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($submit->homework->submission_date)->format('d-m-Y') }}</td>
                            <td>{{ $submit->homework->description ?? '-' }}</td>
                            <td>
                                @if($submit->homework->document_file)
                                    <a href="{{ asset('uploads/homework/'.$submit->homework->document_file) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $submit->description ?? '-' }}</td>
                            <td>
                                @if($submit->document_file)
                                    <a href="{{ asset('uploads/homework/'.$submit->document_file) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No submitted homework found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
