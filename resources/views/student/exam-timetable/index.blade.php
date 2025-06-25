@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title ?? 'Exam Timetable' }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Student</li>
                        <li class="breadcrumb-item active">{{ $header_title ?? 'Exam Timetable' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @forelse ($timetable as $exam => $schedules)
        <div class="row mb-4">
            <div class="card flex-fill comman-shadow w-100">
                <div class="card-header font-weight-bold">
                    <h5 class="card-title mb-0">{{ strtoupper($exam) }}</h5>
                </div>

                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Subject</th>
                                <th>Exam Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Room Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $item)
                            <tr>
                                <td>{{ $item['subject_name'] ?? '--' }}</td>
                                <td>{{ $item['exam_date'] ?? '--' }}</td>
                                <td>{{ $item['start_time'] ? date('h:i A', strtotime($item['start_time'])) : '--' }}</td>
                                <td>{{ $item['end_time'] ? date('h:i A', strtotime($item['end_time'])) : '--' }}</td>
                                <td>{{ $item['room_number'] ?? '--' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No exam timetable found.</div>
    @endforelse
</div>
@endsection
