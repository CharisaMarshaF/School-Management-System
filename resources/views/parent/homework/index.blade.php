@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Student Homework</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Homework Card --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card flex-fill student-space comman-shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Homework List</h5>
                    {{-- Filter Form --}}
                    <form method="GET" class="row g-2">
                        <div class="col-md-5">
                            <select name="subject_id" class="form-control">
                                <option value="">-- Select Subject --</option>
                                @foreach($subjects as $cs)
                                <option value="{{ $cs->subject_id }}"
                                    {{ request('subject_id') == $cs->subject_id ? 'selected' : '' }}>
                                    {{ $cs->subject->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="homework_date" class="form-control"
                                value="{{ request('homework_date') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fe fe-search"></i>
                            </button>
                        </div>

                    </form>
                </div>

                {{-- Table --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Homework Date</th>
                                    <th>Submission Date</th>
                                    <th>Description</th>
                                    <th>Document</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($homeworks as $hw)
                                <tr>
                                    <td>{{ $hw->subject->name ?? '-' }}</td>
                                    <td>{{ $hw->homework_date }}</td>
                                    <td>{{ $hw->submission_date }}</td>
                                    <td>{{ $hw->description }}</td>
                                    <td>
                                        @if($hw->document_file)
                                        <a href="{{ asset('SchoolMS_App/public/uploads/homework/'.$hw->document_file) }}"
                                            target="_blank" class="btn btn-sm btn-link">Download</a>
                                        @else
                                        <span class="text-muted">No file</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No homework found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> {{-- end card-body --}}
            </div> {{-- end card --}}
        </div> {{-- end col --}}
    </div> {{-- end row --}}
</div>
@endsection
