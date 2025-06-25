@extends('layout.app')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">My Account</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Account</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            @if(!empty($user->profile_pic))
                                <img class="rounded-circle" src="{{ asset('SchoolMS_App/public/uploads/' . (['1'=>'admin','2'=>'teacher','3'=>'students','4'=>'parent'][Auth::user()->user_type]) . '/' . $user->profile_pic) }}" alt="Profile Image" width="80">
                            @else
                            <img class="rounded-circle" src="{{ asset('SchoolMS_App/public/uploads/default.png') }}" alt="Default Profile Image" width="80">
                            @endif
                        </div>
                        <div class="col ms-md-n2 profile-user-info">
                            <h4 class="user-name mb-0">{{ $user->name }} {{ $user->last_name ?? '' }}</h4>
                            <div class="text-muted">{{ ucfirst(['1'=>'Admin','2'=>'Teacher','3'=>'Student','4'=>'Parent'][Auth::user()->user_type]) }}</div>
                        </div>
                    </div>
                </div>

                

                <div class="tab-content profile-tab-cont mt-3">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('updateMyAccount') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <label class="col-sm-3 text-muted text-end">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                        </div>
                                    </div>

                                    @if(in_array(Auth::user()->user_type, [2,3,4]))
                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name ?? '' }}">
                                        </div>
                                    </div>
                                    @endif

                                    @if(in_array(Auth::user()->user_type, [2,3,4]))
                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Mobile Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mobile_number" class="form-control" value="{{ $user->mobile_number ?? '' }}">
                                        </div>
                                    </div>
                                    @endif

                                    @if(in_array(Auth::user()->user_type, [2,3,4]))
                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Gender</label>
                                        <div class="col-sm-9">
                                            <select name="gender" class="form-control">
                                                <option value="Male" {{ ($user->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ ($user->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                    @if(Auth::user()->user_type == 2)
                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Qualification</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="qualification" class="form-control" value="{{ $user->qualification ?? '' }}">
                                        </div>
                                    </div>
                                    @endif

                                    @if(Auth::user()->user_type == 4)
                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Occupation</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="occupation" class="form-control" value="{{ $user->occupation ?? '' }}">
                                        </div>
                                    </div>
                                    @endif

                                    @if(in_array(Auth::user()->user_type, [2,3,4]))
                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Address</label>
                                        <div class="col-sm-9">
                                            <textarea name="address" class="form-control">{{ $user->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" value="{{ $user->email }}" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <label class="col-sm-3 text-muted text-end">Profile Picture</label>
                                        <div class="col-sm-9">
                                            @if(!empty($user->profile_pic))
                                                <img src="{{ asset('SchoolMS_App/public/uploads/' . (['1'=>'admin','2'=>'teacher','3'=>'students','4'=>'parent'][Auth::user()->user_type]) . '/' . $user->profile_pic) }}" width="100" class="mb-2"><br>
                                            @endif
                                            <input type="file" name="profile_pic" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12 text-end">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Profile Tab -->

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
