@extends('layout.app')

@section('content')
<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Homework</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Homework</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Success alert --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('homework.index') }}" class="row mb-4">
        <div class="col-md-3">
            <select name="class_id" class="form-control">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="subject_id" class="form-control">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('homework.index') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHomeworkModal">+
                Add Homework</button>
        </div>
    </form>

    {{-- Homework Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Homework Date</th>
                        <th>Submission Date</th>
                        <th>File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homeworks as $index => $hw)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hw->classroom->name ?? '-' }}</td>
                        <td>{{ $hw->subject->name ?? '-' }}</td>
                        <td>{{ $hw->homework_date }}</td>
                        <td>{{ $hw->submission_date }}</td>
                        <td>
                            @if($hw->document_file)
                            <a href="{{ asset('SchoolMS_App/public/uploads/homework/' . $hw->document_file) }}"
                                download>Download</a>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $hw->id }}" title="Detail">
                                <i class="fe fe-eye"></i>
                            </button>

                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $hw->id }}" title="Edit">
                                <i class="fe fe-edit"></i>
                            </button>

                            <form method="POST" action="{{ url('admin/homework/'.$hw->id) }}" style="display:inline;"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </button>
                            </form>

                            <a href="{{ route('homework.submitted.admin', $hw->id) }}" class="btn btn-success btn-sm"
                                title="Submitted Admin">
                                <i class="fe fe-check-circle"></i>
                            </a>
                        </td>

                    </tr>

                    {{-- Detail Modal --}}
                    <div class="modal fade" id="detailModal{{ $hw->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Homework Detail</h5>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Class:</strong> {{ $hw->classroom->name ?? '-' }}</p>
                                    <p><strong>Subject:</strong> {{ $hw->subject->name ?? '-' }}</p>
                                    <p><strong>Homework Date:</strong> {{ $hw->homework_date }}</p>
                                    <p><strong>Submission Date:</strong> {{ $hw->submission_date }}</p>
                                    <p><strong>Description:</strong> {{ $hw->description }}</p>
                                    @if($hw->document_file)
                                    <p><a href="{{ asset('SchoolMS_App/public/uploads/homework/' . $hw->document_file) }}"
                                            download>Download File</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editModal{{ $hw->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('homework.update', $hw->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="modal-header">
                                        <h5>Edit Homework</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label>Class</label>
                                                <select class="form-control" disabled>
                                                    @foreach($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ $hw->class_id == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="class_id" value="{{ $hw->class_id }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label>Subject</label>
                                                <select class="form-control" disabled>
                                                    <option value="{{ $hw->subject_id }}">
                                                        {{ $hw->subject->name ?? '-' }}</option>
                                                </select>
                                                <input type="hidden" name="subject_id" value="{{ $hw->subject_id }}">
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label>Homework Date</label>
                                                <input type="date" name="homework_date" class="form-control"
                                                    value="{{ $hw->homework_date }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Submission Date</label>
                                                <input type="date" name="submission_date" class="form-control"
                                                    value="{{ $hw->submission_date }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label>Document File</label>
                                            <input type="file" name="document_file" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control"
                                                rows="3">{{ $hw->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addHomeworkModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('homework.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Homework</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label>Class</label>
                                <select name="class_id" class="form-control class-select" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Subject</label>
                                <select name="subject_id" class="form-control subject-select" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label>Homework Date</label>
                                <input type="date" name="homework_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Submission Date</label>
                                <input type="date" name="submission_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Document File</label>
                            <input type="file" name="document_file" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Delegasi event untuk semua class-select dalam form modal
        document.querySelectorAll('.class-select').forEach(function (classDropdown) {
            classDropdown.addEventListener('change', function () {
                const classId = this.value;
                const modal = this.closest('.modal');
                const subjectDropdown = modal.querySelector('.subject-select');

                subjectDropdown.innerHTML = '<option value="">Loading...</option>';

                const url = `{{ url('/admin/get-subjects-by-class') }}/${classId}`;

                fetch(url)
                    .then(response => response.json())
                    .then(subjects => {
                        subjectDropdown.innerHTML =
                            '<option value="">Select Subject</option>';
                        subjects.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.text = subject.name;
                            subjectDropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching subjects:", error);
                        subjectDropdown.innerHTML =
                            '<option value="">Select Subject</option>';
                    });
            });
        });
    });
</script>



@endsection
