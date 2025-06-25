@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title ?? 'Parent List' }}</h3>
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
        <div class="card flex-fill parent-space comman-shadow">
            <div class="card-header  align-items-center">

                <form method="GET" action="{{ url('admin/class_timetable/list') }}" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="class_id" class="" >Select Class</label>
                            <select name="class_id" id="class_id" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                <option value="">-- Select Class --</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="subject_id">Subject</label>
                            <select name="subject_id" id="subject_id" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                <option value="">-- Select Subject --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>


                @if(request('class_id') && request('subject_id'))
                <form method="POST" action="{{ url('admin/class_timetable/save') }}">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                    <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Room Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeks as $week)
                                @php
                                    $data = $timetableData[$week->id] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $week->name }}</td>
                                    <td>
                                        <input type="time" name="timetable[{{ $week->id }}][start_time]" value="{{ $data->start_time ?? '' }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="time" name="timetable[{{ $week->id }}][end_time]" value="{{ $data->end_time ?? '' }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="timetable[{{ $week->id }}][room_number]" value="{{ $data->room_number ?? '' }}" class="form-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary mb-5">Save Timetable</button>
                </form>
                @endif
            </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#class_id').change(function () {
            $('#filterForm').submit();
        });

        function loadSubjects() {
            let classId = $('#class_id').val();
            let selectedSubject = '{{ request("subject_id") }}';

            if (classId) {
                $.ajax({
                    url: '{{ url("admin/get-subject-by-class") }}/' + classId,
                    type: 'GET',
                    success: function (response) {
                        $('#subject_id').empty().append('<option value="">-- Select Subject --</option>');
                        $.each(response, function (key, subject) {
                            let selected = subject.id == selectedSubject ? 'selected' : '';
                            $('#subject_id').append(`<option value="${subject.id}" ${selected}>${subject.name}</option>`);
                        });

                        if (selectedSubject) {
                            $('#subject_id').trigger('change');
                        }
                    }
                });
            }
        }

        $('#subject_id').change(function () {
            $('#filterForm').submit();
        });

        loadSubjects();
    });
</script>
@endsection
