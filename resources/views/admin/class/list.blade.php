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
                        <li class="breadcrumb-item active">Class</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title">Class List</h5>
                 <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Form Pencarian -->
                    <form method="GET" action="{{ url('admin/class/list') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name class"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/class/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>

                    <!-- Tombol Tambah -->
                                   <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#signup-modal" id="tambah-class">Add new Class</button>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table star-student table-hover table-center table-borderless table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Amount</th>
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
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->status == 0 ? 'Active' : 'Inactive' }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td class="text-center">
                                    <a href="#" class="edit-modal" data-bs-toggle="modal" data-bs-target="#signup-modal"
                                        data-id="{{ $value->id }}" data-name="{{ $value->name }}" data-status="{{ $value->status }}">
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

<!-- Modal Create/Edit Class -->
<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <h4 class="text-primary">Class Form</h4>
                </div>
                <form class="px-3" id="classForm" method="post" action="{{ url('admin/class/list') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" name="name" type="text" id="name" required placeholder="Enter class name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">amount ( $ )</label>
                        <input class="form-control" name="amount" type="number" id="amount" required placeholder="Enter class amount" value="{{ old('amount') }}">
                        @if ($errors->has('amount'))
                        <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
                        @endif
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
        <div class="modal-content shadow-lg border-0 rounded-3">
            <form id="formHapus" method="GET">
                <div class="modal-header bg-danger text-white rounded-top">
                    <h5 class="modal-title" id="modalHapusLabel"><i class="fe fe-trash-2 me-2"></i>Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-3">Are you sure want to delete this class?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.getElementById('tambah-class').addEventListener('click', function () {
    document.getElementById('classForm').action = "{{ url('admin/class/list') }}";
    document.getElementById('id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('amount').value = '0';
    document.getElementById('status').value = '0';
});

document.querySelectorAll('.edit-modal').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const amount = this.getAttribute('data-amount');

        const status = this.getAttribute('data-status');

        document.getElementById('classForm').action = "{{ url('admin/class/update') }}/" + id;
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('amount').value = amount;
        document.getElementById('status').value = status;
    });
});

document.querySelectorAll('.confirm-delete').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        document.getElementById('formHapus').action = "{{ url('admin/class/delete') }}/" + id;
    });
});
</script>
@endsection
