@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">{{ $header_title }}</h4>

    <div class="card">
        <div class="card-header">
            Assigned Classes & Subjects
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-borderless table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Class</th>
                            <th>Subject Name</th>
                            <th>Subject Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            @forelse($record->classSubjects as $cs)
                                <tr>
                                    <td>{{ $record->class->name ?? '-' }}</td>
                                    <td>{{ $cs->subject->name ?? '-' }}</td>
                                    <td>{{ ucfirst($cs->subject->type ?? '-') }}</td>
                                    <td>
                                        <a href="{{ route('teacher.class.subject.timetable', ['class_id' => $record->class_id, 'subject_id' => $cs->subject_id]) }}"
                                           class="btn btn-sm btn-primary">Timetable</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{ $record->class->name ?? '-' }}</td>
                                    <td colspan="3" class="text-center">No subjects assigned</td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No assigned classes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
