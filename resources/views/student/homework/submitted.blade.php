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
                        <li class="breadcrumb-item active">Submitted Homework</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <select name="subject_id" class="form-control">
                <option value="">All Subjects</option>
                @foreach($subjects as $id => $name)
                    <option value="{{ $id }}" {{ request('subject_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="date" name="homework_date" class="form-control" value="{{ request('homework_date') }}">
        </div>
        <div class="col-md-4 d-flex align-items-start">
            <button class="btn btn-primary me-2">🔍 Search</button>
            <a href="{{ route('student.homework.submitted') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Table --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Homework Date</th>
                        <th>Submission Date</th>
                        <th>Your Description</th>
                        <th>Your File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $index => $sub)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sub->homework->subject->name ?? '-' }}</td>
                        <td>{{ $sub->homework->homework_date }}</td>
                        <td>{{ $sub->homework->submission_date }}</td>
                        <td>{{ $sub->description }}</td>
                        <td>
                            @if($sub->document_file)
                                <a href="{{ asset('SchoolMS_App/public/uploads/homework/' . $sub->document_file) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No submitted homework found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
