@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="page-title mb-0">{{ $header_title }}</h3>
            </div>
            <div class="col-sm-6 text-sm-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 justify-content-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $header_title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(count($exams) == 0)
        <div class="alert alert-info">No exam result found.</div>
    @else
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3">List of Exams:</h5>
            <ul class="list-group">
                @foreach($exams as $exam)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $exam->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @foreach($allResults as $examResult)
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-secondary text-white fw-bold">
            Exam: {{ $examResult['exam']->name }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Subject Name</th>
                            <th>Class Work</th>
                            <th>Test Work</th>
                            <th>Home Work</th>
                            <th>Exam</th>
                            <th>Total Score</th>
                            <th>Passing Marks</th>
                            <th>Full Marks</th>
                            <th>%</th>
                            <th>Grade</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examResult['results'] as $row)
                        <tr class="text-center">
                            <td class="text-start">{{ $row['subject_name'] }}</td>
                            <td>{{ $row['class_work'] }}</td>
                            <td>{{ $row['test_work'] }}</td>
                            <td>{{ $row['home_work'] }}</td>
                            <td>{{ $row['exam'] }}</td>
                            <td>{{ $row['total'] }}</td>
                            <td>{{ $row['passing_marks'] }}</td>
                            <td>{{ $row['full_marks'] }}</td>
                            <td>{{ $row['percent'] }}%</td>
                            <td>{{ $row['grade'] }}</td>
                            <td>
                                @if($row['result'] == 'Pass')
                                    <span class="badge bg-success">{{ $row['result'] }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $row['result'] }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr class="fw-bold text-center bg-light">
                            <td colspan="5" class="text-end">Grand Total:</td>
                            <td>{{ $examResult['totalScore'] }}/{{ $examResult['totalFullMarks'] }}</td>
                            <td colspan="2" class="text-end">Percentage:</td>
                            <td>{{ $examResult['percentage'] }}%</td>
                            <td colspan="2">Grade: {{ $examResult['overallGrade'] }}</td>
                        </tr>
                        <tr class="fw-bold text-center bg-light">
                            <td colspan="9" class="text-end">Result:</td>
                            <td colspan="2">
                                @if($examResult['overallResult'] == 'Pass')
                                    <span class="badge bg-success">Pass</span>
                                @else
                                    <span class="badge bg-danger">Fail</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
