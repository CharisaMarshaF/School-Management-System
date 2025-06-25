@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">{{ $header_title }}</h4>

    <div class="card">
        <div class="card-header">
            Assigned Subjects
        </div>
        <div class="card-body">
            <p><strong>Class:</strong> {{ $student->class->name ?? '-' }}</p>

            <div class="table-responsive">
                <table class="table table-hover table-borderless table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Subject Name</th>
                            <th>Type</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $item)
                        <tr>
                            <td>{{ $item->subject->name ?? '-' }}</td>
                            <td>{{ ucfirst($item->subject->type ?? '-') }}</td>
                            <td>
                                <a href="{{ route('parent.student.timetable', [$student->id, $student->class_id, $item->subject_id]) }}" class="btn btn-sm btn-primary">
                                    My Class Timetable
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">No subjects assigned</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Back</a>
        </div>
    </div>
</div>
@endsection
