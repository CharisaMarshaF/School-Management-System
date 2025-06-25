@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('student.notice_board') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="title" class="form-control" placeholder="Search Title" value="{{ request('title') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="notice_date_from" class="form-control" value="{{ request('notice_date_from') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="notice_date_to" class="form-control" value="{{ request('notice_date_to') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <!-- Notice Cards -->
    @if($notices->count() > 0)
        <div class="row">
            @foreach($notices as $notice)
                <div class="col-md-12 mb-4"> <!-- Diubah dari col-md-6 menjadi col-md-12 -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $notice->title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Notice Date: {{ \Carbon\Carbon::parse($notice->notice_date)->format('d M Y') }}
                            </h6>
                            <p class="card-text">{{ $notice->message }}</p>
                        </div>
                        <div class="card-footer text-muted">
                            Published at: {{ \Carbon\Carbon::parse($notice->publish_date)->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No notices found for students.</div>
    @endif
</div>
@endsection
