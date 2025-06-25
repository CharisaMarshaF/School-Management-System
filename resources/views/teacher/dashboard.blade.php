@extends('layout.app')

@section('content')
<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">Welcome Teacher {{ Auth::user()->name }}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Teacher Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
       @php
    $widgets = [
        ['label' => 'Students', 'value' => $students, 'icon' => 'fe fe-users'],
        ['label' => 'Classes', 'value' => $classCount, 'icon' => 'fe fe-layers'],
        ['label' => 'Subjects', 'value' => $subjectCount, 'icon' => 'fe fe-book-open'],
        ['label' => 'Notices', 'value' => $noticeCount, 'icon' => 'fe fe-bell'],
    ];
@endphp


        @foreach($widgets as $widget)
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
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
@endsection
