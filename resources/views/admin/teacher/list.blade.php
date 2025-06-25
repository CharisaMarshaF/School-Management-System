@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title ?? 'Teacher List' }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                        <li class="breadcrumb-item active">Teachers</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="card flex-fill comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Teachers</h5>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="GET" action="{{ url('admin/teacher/list') }}"
                        class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name or email"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/teacher/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAddTeacher">
                        <i class="fe fe-plus"></i> Add Teacher
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center table-borderless table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Qualification</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getRecord as $index => $teacher)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($teacher->profile_pic)
                                    <img src="{{ asset('SchoolMS_App/public/uploads/teacher/' . $teacher->profile_pic) }}" width="40"
                                        height="40" class="rounded-circle" style="object-fit: cover;">
                                    @else
                                    <span class="text-muted">No Photo</span>
                                    @endif
                                </td>
                                <td>{{ $teacher->name }} {{ $teacher->last_name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->mobile_number }}</td>
                                <td>{{ $teacher->qualification }}</td>
                                <td>
                                    @if($teacher->status == 0)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#editTeacherModal{{ $teacher->id }}">
                                        <i class="fe fe-edit text-primary"></i>
                                    </a>
                                    <a href="{{ url('admin/teacher/delete/'.$teacher->id) }}"
                                        onclick="return confirm('Delete this teacher?')">
                                        <i class="fe fe-trash-2 text-danger"></i>
                                    </a>
                                </td>
                            </tr>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editTeacherModal{{ $teacher->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ url('admin/teacher/update/'.$teacher->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Teacher</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @include('admin.teacher.form-fields', ['teacher' => $teacher])
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="modalAddTeacher" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ url('admin/teacher/insert') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Teacher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.teacher.form-fields', ['teacher' => null])
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
   // Saat klik tombol edit
$('.editTeacherBtn').on('click', function () {
    const id = $(this).data('id');

    $.get(`/teacher/${id}/edit`, function (data) {
        $('#teacherModalLabel').text('Edit Teacher');
        $('#teacherForm').attr('action', `/teacher/${id}`);
        $('#teacherForm').attr('method', 'PUT');

        // Isi data ke input
        $('#name').val(data.name);
        $('#last_name').val(data.last_name);
        $('#email').val(data.email);
        $('#mobile_number').val(data.mobile_number);
        $('#gender').val(data.gender);
        $('#date_of_birth').val(data.date_of_birth);
        $('#date_of_joining').val(data.date_of_joining);
        $('#marital_status').val(data.marital_status);
        $('#qualification').val(data.qualification);
        $('#work_experience').val(data.work_experience);
        $('#note').val(data.note);
        $('#status').val(data.status);
        $('#address').val(data.address);
        $('#permanent_address').val(data.permanent_address);
        
        $('#teacher_id').val(data.id); // untuk hidden input id jika perlu

        $('#teacherModal').modal('show');
    });
});
</script>