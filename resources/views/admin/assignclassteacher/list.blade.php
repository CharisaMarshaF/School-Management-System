@extends('layout.app')

@section('content')
<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">{{ $header_title }}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Assign Class to Teacher</li>
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
                <h5 class="card-title mb-0">Assigned Classes</h5>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="GET" action="{{ url('admin/assign_class_teacher/list') }}"
                        class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search teacher name or email" value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit"><i class="fe fe-search"></i>
                                Search</button>
                            <a href="{{ url('admin/assign_class_teacher/list') }}" class="btn btn-outline-secondary"><i
                                    class="fe fe-rotate-ccw"></i> Reset</a>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal"
                        data-bs-target="#assignClassModal" id="btnAddAssign">Add Assignment</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center table-borderless table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getRecord as $item)
                            @if($item->teacher && $item->teacher->user_type == 2 && $item->teacher->is_delete == 0)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->class->name ?? '-' }}</td>
                                <td>{{ $item->teacher->name ?? '-' }} {{ $item->teacher->last_name ?? '' }}</td>
                                <td>
                                    @if($item->status == 0)
                                    Active
                                    @elseif($item->status == 1)
                                    Inactive
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                <td class="text-">
                                    {{-- <a href="#" class="edit-modal" data-bs-toggle="modal"
                                        data-bs-target="#assignClassModal" data-class_id="{{ $item->class_id }}"
                                        data-teacher_ids="{{ $item->teacher_id }}" data-status="{{ $item->status }}">
                                        <i class="fe fe-edit text-primary"></i>
                                    </a> --}}
                                    <a href="#" class="confirm-delete" data-bs-toggle="modal"
                                        data-bs-target="#modalDelete" data-id="{{ $item->id }}">
                                        <i class="fe fe-trash-2 text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal Add/Edit -->
<div id="assignClassModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center text-primary">Assign Class to Teachers</h4>
                <form id="assignClassForm" method="POST" action="{{ route('admin.assign_class_teacher.insert') }}">
                    @csrf
                    <input type="hidden" name="id" id="assign_id">

                    <div class="mb-3">
                        <label class="form-label">Select Class</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Teachers</label>
                        <div>
                            @foreach($teachers as $teacher)
                            @if($teacher->user_type == 2 && $teacher->is_delete == 0)
                            <div class="form-check">
                                <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}"
                                    class="form-check-input teacher_checkbox">
                                <label class="form-check-label">{{ $teacher->name }} {{ $teacher->last_name }}</label>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary">Save Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formDelete" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalDeleteLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete this assignment?</p>
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
    document.getElementById('btnAddAssign').addEventListener('click', function () {
        document.getElementById('assignClassForm').action = "{{ route('admin.assign_class_teacher.insert') }}";
        document.getElementById('assign_id').value = '';
        document.getElementById('class_id').disabled = false;
        document.getElementById('class_id').value = '';
        document.querySelectorAll('.teacher_checkbox').forEach(cb => cb.checked = false);
        document.getElementById('status').value = '0';
    });

    document.querySelectorAll('.edit-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const class_id = this.getAttribute('data-class_id');
            const teacher_ids = this.getAttribute('data-teacher_ids').split(',');
            const status = this.getAttribute('data-status');

            document.getElementById('assignClassForm').action =
                "{{ url('admin/assign_class_teacher/update') }}/" + class_id;
            document.getElementById('class_id').value = class_id;
            document.getElementById('class_id').disabled = true;

            document.querySelectorAll('.teacher_checkbox').forEach(cb => {
                cb.checked = teacher_ids.includes(cb.value);
            });

            document.getElementById('status').value = status;
        });
    });

    document.querySelectorAll('.confirm-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('formDelete').action =
                "{{ url('admin/assign_class_teacher/delete') }}/" + id;
        });
    });
</script>

@endsection
