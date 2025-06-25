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
                        <li class="breadcrumb-item active">Submitted Homework</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="row">
        <div class="card flex-fill comman-shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Submitted Homework for:
                    <strong>{{ $homework->subject->name }} ({{ $homework->classroom->name }})</strong>
                </h5>
            </div>

            <div class="card-body">
                <!-- Search -->
                <form method="GET" action="{{ url()->current() }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ $search }}" class="form-control"
                            placeholder="Search student name">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary"><i class="fe fe-search"></i> Search</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary"><i class="fe fe-rotate-ccw"></i> Reset</a>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-center table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Description</th>
                                <th>Submitted File</th>
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $index => $submit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $submit->student->name }}</td>
                                <td>{{ $submit->description }}</td>
                                <td>
                                    @if($submit->document_file)
                                        <a href="{{ asset('SchoolMS_App/public/uploads/homework/' . $submit->document_file) }}" target="_blank" download>
                                            <i class="fe fe-download"></i> Download
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $submit->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No submissions found.</td>
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
