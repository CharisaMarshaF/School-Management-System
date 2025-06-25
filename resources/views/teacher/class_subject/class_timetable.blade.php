@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title ?? 'My Class List' }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Teacher</li>
                        <li class="breadcrumb-item active">{{ $header_title ?? 'My Class List' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card flex-fill parent-space comman-shadow">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ $subject->name ?? 'Unknown Subject' }}</h5>

                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Week</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Room Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($timetable as $item)
                            <tr>
                                <td>{{ $item['week_name'] }}</td>
                                <td>{{ $item['start_time'] ? date('h:i A', strtotime($item['start_time'])) : '--' }}
                                </td>
                                <td>{{ $item['end_time'] ? date('h:i A', strtotime($item['end_time'])) : '--' }}</td>
                                <td>{{ $item['room_number'] ?? '--' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No schedule found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
