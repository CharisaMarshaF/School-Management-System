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
                        <li class="breadcrumb-item active">Subject</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Star Students</h5>
                 <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Form Pencarian -->
                    <form method="GET" action="{{ url('admin/subject/list') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name or email"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/subject/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>

                    <!-- Tombol Tambah -->
                                    <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#signup-modal" id="tambah-subject">Add new Subject</button>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center table-borderless table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getRecord as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->type }}</td>
                                <td>{{ $value->status == 0 ? 'Active' : 'Inactive' }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td class="text-center">
                                    <a href="#" class="edit-modal" data-bs-toggle="modal" data-bs-target="#signup-modal"
                                        data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-type="{{ $value->type }}" data-status="{{ $value->status }}">
                                        <i class="fe fe-edit text-primary"></i>
                                    </a>
                                    <a href="#" class="confirm-delete" data-bs-toggle="modal" data-bs-target="#modalHapus" data-id="{{ $value->id }}">
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

<!-- Modal Create/Edit Subject -->
<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center text-primary">Subject Form</h4>
                <form id="subjectForm" method="post" action="{{ url('admin/subject/list') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" name="name" type="text" id="name" required placeholder="Enter subject name" value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="">-- Select Type --</option>
                            <option value="Theory" {{ old('type') == 'Theory' ? 'selected' : '' }}>Theory</option>
                            <option value="Practical" {{ old('type') == 'Practical' ? 'selected' : '' }}>Practical</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active</option>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Inactive</option>
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
            <form id="formHapus" method="GET">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure want to delete this subject?</p>
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
document.getElementById('tambah-subject').addEventListener('click', function () {
    document.getElementById('subjectForm').action = "{{ url('admin/subject/list') }}";
    document.getElementById('id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('type').value = '';
    document.getElementById('status').value = '0';
});

document.querySelectorAll('.edit-modal').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const type = this.getAttribute('data-type');
        const status = this.getAttribute('data-status');

        document.getElementById('subjectForm').action = "{{ url('admin/subject/update') }}/" + id;
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('type').value = type;
        document.getElementById('status').value = status;
    });
});

document.querySelectorAll('.confirm-delete').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        document.getElementById('formHapus').action = "{{ url('admin/subject/delete') }}/" + id;
    });
});
</script>
@endsection
