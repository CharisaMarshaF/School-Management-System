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

<div class="row">

    <div class="card flex-fill student-space comman-shadow">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">My Students</h5>
            <ul class="chart-list-out student-ellips">
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Form Pencarian -->
                    <form method="GET" action="{{ url('admin/student/list') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name or email"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/student/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>

                    <!-- Tombol Tambah -->
                     <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addStudentModal"
                >+ Add Student</button>
                </div>
           
        </div>

    <!-- Table -->
    <div class="card-body">
         @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        <div class="table-responsive">
            <table class="table star-student table-hover table-center table-borderless table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Photo</th> 
                        <th>Class</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>DOB</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getRecord as $student)
                        <tr>
                            <td>{{ $student->name }} {{ $student->last_name }}</td>
                            <td>
                                @if($student->profile_pic)
                                 <a href="#" data-bs-toggle="modal" data-bs-target="#viewImageModal{{ $student->id }}">
                                    <img src="{{ asset('SchoolMS_App/public/uploads/students/'.$student->profile_pic) }}" width="40">
                                </a>
                                @else
                                    <span class="text-muted">No Photo</span>
                                @endif
                            </td>

                            <td>{{ $student->class->name ?? '-' }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->address }}</td>

                            <td>{{ $student->date_of_birth }}</td>
                            <td>{{ $student->mobile_number }}</td>
                            <td>
                                @if($student->status == 0)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" class="edit-modal" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $student->id }}">
                                    <i class="fe fe-edit text-primary"></i>
                                </a>

                                <a href="{{ url('admin/student/delete/'.$student->id) }}" onclick="return confirm('Delete this student?')">
                                    <i class="fe fe-trash-2 text-danger"></i>
                                </a>
                            </td>

                        </tr>
                        <!-- Modal View Image -->
                        <div class="modal fade" id="viewImageModal{{ $student->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('SchoolMS_App/public/uploads/students/'.$student->profile_pic) }}" alt="Student Photo" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
