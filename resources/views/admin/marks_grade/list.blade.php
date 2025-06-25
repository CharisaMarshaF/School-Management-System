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
                        <li class="breadcrumb-item active">Marks Grade</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title">Marks Grade List</h5>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="GET" action="{{ url('admin/marks-grade/list') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name grade"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/marks-grade/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>

                    <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#signup-modal" id="tambah-grade">Add new Grade</button>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover table-center table-borderless table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>From (%)</th>
                                <th>To (%)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($getRecord as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->percent_from }}%</td>
                                <td>{{ $value->percent_to }}%</td>
                                <td>
                                    <a href="#" class="edit-modal" data-bs-toggle="modal" data-bs-target="#signup-modal"
                                        data-id="{{ $value->id }}"
                                        data-name="{{ $value->name }}"
                                        data-from="{{ $value->percent_from }}"
                                        data-to="{{ $value->percent_to }}">
                                        <i class="fe fe-edit text-primary"></i>
                                    </a>
                                    <a href="#" class="confirm-delete" data-bs-toggle="modal" data-bs-target="#modalHapus" data-id="{{ $value->id }}">
                                        <i class="fe fe-trash-2 text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @if($getRecord->count() == 0)
                            <tr><td colspan="6" class="text-center">No data found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div id="signup-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <h4 class="text-primary">Marks Grade Form</h4>
                </div>
                <form class="px-3" id="gradeForm" method="post" action="{{ url('admin/marks-grade/list') }}">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Grade Name</label>
                        <input class="form-control" name="name" type="text" id="name" required placeholder="Enter grade name">
                    </div>
                    <div class="mb-3">
                        <label for="percent_from" class="form-label">Percent From</label>
                        <input class="form-control" name="percent_from" type="number" id="percent_from" required placeholder="0">
                    </div>
                    <div class="mb-3">
                        <label for="percent_to" class="form-label">Percent To</label>
                        <input class="form-control" name="percent_to" type="number" id="percent_to" required placeholder="100">
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
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <form id="formHapus" method="GET">
                <div class="modal-header bg-danger text-white rounded-top">
                    <h5 class="modal-title"><i class="fe fe-trash-2 me-2"></i>Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure want to delete this grade?</p>
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
document.getElementById('tambah-grade').addEventListener('click', function () {
    document.getElementById('gradeForm').action = "{{ url('admin/marks-grade/list') }}";
    document.getElementById('id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('percent_from').value = '';
    document.getElementById('percent_to').value = '';
});

document.querySelectorAll('.edit-modal').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const from = this.dataset.from;
        const to = this.dataset.to;

        document.getElementById('gradeForm').action = "{{ url('admin/marks-grade/update') }}/" + id;
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('percent_from').value = from;
        document.getElementById('percent_to').value = to;
    });
});

document.querySelectorAll('.confirm-delete').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        document.getElementById('formHapus').action = "{{ url('admin/marks-grade/delete') }}/" + id;
    });
});
</script>
@endsection
