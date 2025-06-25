    @extends('layout.app')

    @section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">
                            {{ $header_title ?? 'Parent List' }} for: {{ $student->name }} {{ $student->last_name }}
                        </h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">Admin</li>
                            <li class="breadcrumb-item active">Class TimeTable</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($timetable as $exam => $subjects)
            <div class="col-12">
                <div class="card flex-fill parent-space comman-shadow mb-4">
                    <div class="card-header bg-white border-bottom font-weight-bold">
                        <h5 class="mb-0 text-uppercase">{{ $exam }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
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
                                    @foreach ($subjects as $subject => $schedules)
                                    @foreach ($schedules as $item)
                                    <tr>
                                        <td>{{ $subject }}</td>
                                        <td>{{ $item['exam_date'] ?? '--' }}</td>
                                        <td>{{ $item['start_time'] ? date('h:i A', strtotime($item['start_time'])) : '--' }}
                                        </td>
                                        <td>{{ $item['end_time'] ? date('h:i A', strtotime($item['end_time'])) : '--' }}
                                        </td>
                                        <td>{{ $item['room_number'] ?? '--' }}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">No exam timetable available.</div>
            </div>

            @endforelse
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    </div>
    </div>

    @endsection
