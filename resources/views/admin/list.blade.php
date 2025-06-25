@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <h3 class="page-title">{{ $header_title }}</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Parents</h5>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addModal">Add Parent</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parents as $key => $parent)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $parent->name }} {{ $parent->last_name }}</td>
                        <td>{{ $parent->mobile_number }}</td>
                        <td>{{ $parent->email }}</td>
                        <td>{{ $parent->status == 0 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            @if($parent->profile_pic)
                                <img src="{{ asset($parent->profile_pic) }}" width="50" height="50">
                            @endif
                        </td>
                        <td>
                            {{-- Edit and Delete --}}
                            <form action="{{ url('admin/parent/delete/'.$parent->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ url('admin/parent/insert') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Parent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 mb-3">
                    <label>First Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Mobile Number</label>
                    <input type="text" name="mobile_number" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Occupation</label>
                    <input type="text" name="occupation" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Profile Picture</label>
                    <input type="file" name="profile_pic" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection
