@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Fees Collection</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card flex-fill comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                <h5 class="card-title mb-0">Student Fees List</h5>
                <form method="GET" class="row g-2 align-items-center mb-0">
    <div class="col-auto">
        <select name="class_name" class="form-select">
            <option value="">-- Select Class --</option>
            @foreach($classes as $id => $name)
                <option value="{{ $id }}" {{ request('class_name') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-auto">
        <input type="text" name="student_name" class="form-control"
            placeholder="Search by student name" value="{{ request('student_name') }}">
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary">
            <i class="fe fe-search"></i> Search
        </button>
    </div>

    <div class="col-auto">
        <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
            <i class="fe fe-rotate-ccw"></i> Reset
        </a>
    </div>
</form>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->class->name ?? '-' }}</td>
                                    <td>{{ $student->class->amount ?? 0 }}</td>
                                    <td>{{ $student->fees->paid_amount ?? 0 }}</td>
                                    <td>{{ $student->fees->remaning_amount ?? ($student->fees->total_amount ?? 0) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.fees.collect', $student->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fe fe-dollar-sign"></i> Collect Fees
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No student data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
