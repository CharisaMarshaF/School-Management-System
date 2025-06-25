@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Assign Student to Parent</h4>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            Students Without Parent
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-center table-borderless table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Class</th>
                            <th>Gender</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($availableStudents as $student)
                        <tr>
                            <td>
                                @if($student->profile_pic)
                                <img src="{{ asset('SchoolMS_App/public/uploads/students/'.$student->profile_pic) }}"
                                    width="50" height="50" class="rounded-circle" alt="Profile">
                                @else
                                <span class="text-muted">No Photo</span>
                                @endif
                            </td>
                            <td>{{ $student->name }} {{ $student->last_name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->class->name ?? '-' }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>-</td>
                            <td>
                                <a href="{{ url('admin/parent/assign-child/'.$student->id.'/'.$parent_id) }}"
                                    title="Assign">
                                    <i class="fe fe-plus-circle text-success"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No students available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabel Siswa yang Sudah Diberikan Parent --}}
    <div class="card">
        <div class="card-header">
            Students Assigned to This Parent
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-center table-borderless table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Class</th>
                        <th>Gender</th>
                        <th>Parent</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assignedStudents as $student)
                    <tr>
                        <td>
                            @if($student->profile_pic)
                            <img src="{{ asset('SchoolMS_App/public/uploads/students/'.$student->profile_pic) }}"
                                width="50" height="50" class="rounded-circle" alt="Profile">
                            @else
                            <span class="text-muted">No Photo</span>
                            @endif
                        </td>
                        <td>{{ $student->name }} {{ $student->last_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->class->name ?? '-' }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->parent->name ?? '-' }}</td>
                        <td>
                            <a href="{{ url('admin/parent/remove-child/'.$student->id) }}"
                                onclick="return confirm('Remove this student from parent?')" title="Remove">
                                <i class="fe fe-trash-2 text-danger"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No students assigned</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection
