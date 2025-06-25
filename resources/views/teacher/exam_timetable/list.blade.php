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
                        <li class="breadcrumb-item active">Teacher</li>
                        <li class="breadcrumb-item active">{{ $header_title ?? 'Exam Timetable' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @forelse ($classes_timetable as $class)
    <div class="mb-5">
        <h4 class="font-weight-bold mb-3">Class: {{ $class['class_name'] }}</h4>

        @forelse ($class['timetable'] as $exam => $subjects)
        <div class="row">
            <div class="card flex-fill parent-space comman-shadow">
                <div class="card flex-fill comman-shadow mb-4">
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
                                @foreach ($subjects as $item)
                                <tr>
                                    <td>{{ $item['subject_name'] ?? '--' }}</td>
                                    <td>{{ $item['exam_date'] ?? '--' }}</td>
                                    <td>{{ $item['start_time'] ? date('h:i A', strtotime($item['start_time'])) : '--' }}
                                    </td>
                                    <td>{{ $item['end_time'] ? date('h:i A', strtotime($item['end_time'])) : '--' }}
                                    </td>
                                    <td>{{ $item['room_number'] ?? '--' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">No exam timetable found for this class.</div>
                @endforelse
            </div>
            @empty
            <div class="alert alert-info">You are not assigned to any classes or no exam timetable found.</div>
            @endforelse
            </div>
        </div>
               
        </div>
    </div>
</div>

        @endsection
