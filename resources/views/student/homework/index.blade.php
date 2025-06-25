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
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

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
        <div class="col-md-4 d-flex justify-content-start align-items-start">
            <button class="btn btn-primary me-2" type="submit">🔍 Search</button>
            <a href="{{ route('homework.index') }}" class="btn btn-secondary">Reset</a>
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
                        <th>Document</th>
                        <th>Detail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($homeworks as $index => $hw)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hw->subject->name ?? '-' }}</td>
                        <td>{{ $hw->homework_date }}</td>
                        <td>{{ $hw->submission_date }}</td>
                        <td>
                            @if($hw->document_file)
                                <a href="{{ asset('SchoolMS_App/public/uploads/homework/'.$hw->document_file) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $hw->id }}">
                                View
                            </button>
                        </td>
                        <td>
                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#submit{{ $hw->id }}">Submit
                        </button>
                            </td>
                    </tr>

                    {{-- Detail Modal --}}
                    <div class="modal fade" id="detailModal{{ $hw->id }}" tabindex="-1">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">📄 Homework Detail</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Subject:</strong> {{ $hw->subject->name ?? '-' }}</p>
                                    <p><strong>Homework Date:</strong> {{ $hw->homework_date }}</p>
                                    <p><strong>Submission Date:</strong> {{ $hw->submission_date }}</p>
                                    {{-- <p><strong>Description:</strong> {{ $hw->description }}</p> --}}
                                    @if($hw->document_file)
                                        <p><strong>Document:</strong>
                                            <a href="{{ asset('SchoolMS_App/public/uploads/homework/'.$hw->document_file) }}" target="_blank" class="btn btn-sm btn-success mt-1">
                                                📥 Download File
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No homework found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Submit Homework -->
@foreach($homeworks as $hw)
<div class="modal fade" id="submit{{ $hw->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('student.homework.submit') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <input type="hidden" name="homework_id" value="{{ $hw->id }}">
            <div class="modal-header">
                <h5 class="modal-title">Submit Homework - {{ $hw->subject->name ?? '' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter your description..."></textarea>
                </div>
                <div class="mb-3">
                    <label>Upload File (Image/PDF/DOC)</label>
                    <input type="file" name="document_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit Homework</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
