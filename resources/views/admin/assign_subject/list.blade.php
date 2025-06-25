@extends('layout.app')

@section('content')
<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{ $header_title }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Assign Subject</li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Assigned Subjects</h5>
                <div class="d-flex align-items-center gap-2 flex-wrap">

                    <form method="GET" action="{{ url('admin/assign_subject/list') }}"
                        class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name or email"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/assign_subject/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                        data-bs-target="#assign-modal" id="tambah-assign">Add Assignment</button>
                </div>
            </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-center table-borderless table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Class</th>
                            <th>Subjects</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($getRecord as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->class->name ?? '-' }}</td>
                            <td>{{ $value->subject->name ?? '-' }}</td>

                            <!-- Periksa nilai status dan tampilkan "Active" atau "Inactive" -->
                            <td>
                                @if($value->status == 0)
                                Active
                                @elseif($value->status == 1)
                                Inactive
                                @else
                                N/A
                                @endif
                            </td>

                            <td>{{ $value->created_at }}</td>
                            <td class="text-center">
                               
                                <a href="#" class="confirm-delete" data-bs-toggle="modal" data-bs-target="#modalHapus"
                                    data-id="{{ $value->id }}">
                                    <i class="fe fe-trash-2 text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Modal Create/Edit Assign -->
<div id="assign-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center text-primary">Assign Subjects to Class</h4>
                <form id="assignForm" method="post" action="{{ route('admin.assign_subject.insert') }}">
                    @csrf
                    <input type="hidden" name="class_id" id="class_id_hidden">

                    <div class="mb-3">
                        <label for="class_id" class="form-label">Select Class</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Subjects</label>
                        <div>
                            @foreach($subjects as $subject)
                            <div class="form-check">
                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"
                                    class="form-check-input subject_checkbox">
                                <label class="form-check-label">{{ $subject->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>

                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure want to delete this assignment?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tambah-assign').addEventListener('click', function () {
        document.getElementById('assignForm').action = "{{ route('admin.assign_subject.insert') }}";
        document.getElementById('class_id').disabled = false;
        document.getElementById('class_id').value = '';
        document.querySelectorAll('.subject_checkbox').forEach(checkbox => checkbox.checked = false);
        document.getElementById('status').value = 'active';
    });

    document.querySelectorAll('.edit-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const class_id = this.getAttribute('data-class_id');
            const subject_id = this.getAttribute('data-subject_id');
            const status = this.getAttribute('data-status');

            document.getElementById('assignForm').action = "{{ url('admin/assign_subject/update') }}/" +
                class_id;
            document.getElementById('class_id').value = class_id;
            document.getElementById('class_id').disabled = true;

            document.querySelectorAll('.subject_checkbox').forEach(checkbox => {
                checkbox.checked = (checkbox.value == subject_id);
            });

            document.getElementById('status').value = status;
        });
    });

    document.querySelectorAll('.confirm-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('formHapus').action = "{{ url('admin/assign_subject/delete') }}/" +
                id;
        });
    });
</script>

@endsection
