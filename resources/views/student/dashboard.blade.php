@extends('layout.app')

@section('content')
<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">Welcome {{ Auth::user()->name }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @php
        $widgets = [
            [
                'label' => 'Total Paid Amount',
                'value' => isset($totalPaid) ? 'Rp ' . number_format($totalPaid, 0, ',', '.') : 'Rp 0',
                'icon' => 'fe fe-dollar-sign'
            ],
            [
                'label' => 'Total Subjects',
                'value' => $subjectCount ?? 0,
                'icon' => 'fe fe-book-open'
            ],
            [
                'label' => 'Total Notices',
                'value' => $noticeCount ?? 0,
                'icon' => 'fe fe-bell'
            ],
            [
                'label' => 'Total Homework',
                'value' => $homeworkCount ?? 0,
                'icon' => 'fe fe-file-text'
            ],
            [
                'label' => 'Submitted Homework',
                'value' => $submittedHomeworkCount ?? 0,
                'icon' => 'fe fe-check-circle'
            ],
            [
                'label' => 'Total Attendance',
                'value' => $attendanceCount ?? 0,
                'icon' => 'fe fe-calendar'
            ],
        ];
    @endphp

    <div class="row">
        @foreach($widgets as $widget)
        <div class="col-xl-4 col-sm-6 col-12 d-flex">
            <div class="card bg-comman w-100">
                <div class="card-body">
                    <div class="db-widgets d-flex justify-content-between align-items-center">
                        <div class="db-info">
                            <h6>{{ $widget['label'] }}</h6>
                            <h3>{{ $widget['value'] }}</h3>
                        </div>
                        <div class="db-icon">
                            <i class="{{ $widget['icon'] }} text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>

</div>
@endsection
