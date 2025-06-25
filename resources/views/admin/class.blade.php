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

<div class="row">

    <div class="card flex-fill student-space comman-shadow">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title">Star Students</h5>
            <ul class="chart-list-out student-ellips">
                </li>
            </ul>
            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#signup-modal"
                id="tambah-admin">Add new Admin</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table star-student table-hover table-center table-borderless table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Created Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($getRecord as $value)
                        <tr>
                            <td class="text-nowrap">
                                <div>{{ $loop->iteration }}</div>
                            </td>
                            <td class="text-nowrap">
                                {{ $value->name }}
                            </td>
                            <td class="text-center">{{  $value->email }}</td>
                            <td class="text-center">{{ $value->created_at }}</td>
                            <td class="text-center">
                                <!-- Tombol Hapus -->
                                <a href="#" class="confirm-delete" data-bs-toggle="modal" data-bs-target="#modalHapus"
                                    data-id="{{ $value->id }}">
                                    <i class="fe fe-trash-2 text-danger"></i>
                                </a>


                                <a href="#" class="edit-modal" data-bs-toggle="modal" data-bs-target="#signup-modal"
                                    data-id="{{ $value->id }}" data-name="{{ $value->name }}"
                                    data-email="{{ $value->email }}">
                                    <i class="fe fe-edit text-primary"></i>
                                </a>


                            </td>



                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
</div>


<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <div class="auth-logo">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-lg">
                                <img src="assets/img/logo.png" alt="" height="42">
                            </span>
                        </a>
                    </div>
                </div>
                <form class="px-3" action="{{ url('admin/admin/list') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input class="form-control" name="name" type="text" id="username" required=""
                            placeholder="Michael Zenaty" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="emailaddress" class="form-label">Email address</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                            id="emailaddress" required="" placeholder="john@deo.com" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" required="" id="password"
                            placeholder="Enter your password">
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Konfirmasi Hapus -->
<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <form id="formHapus" method="GET">
                <div class="modal-header bg-danger text-white rounded-top">
                    <h5 class="modal-title" id="modalHapusLabel"><i class="fe fe-trash-2 me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-3">Apakah kamu yakin ingin menghapus data admin ini?</p>
                    <i class="fe fe-alert-triangle text-warning" style="font-size: 40px;"></i>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var myModal = new bootstrap.Modal(document.getElementById('signup-modal'));
        myModal.show();
    });
</script>
@endif


<script>
    document.getElementById('tambah-admin').addEventListener('click', function () {
        document.querySelector('#signup-modal form').action = "{{ url('admin/admin/list') }}";
        document.getElementById('username').value = '';
        document.getElementById('emailaddress').value = '';
        document.getElementById('password').required = true;
    });

    document.querySelectorAll('.edit-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');

            document.querySelector('#signup-modal form').action = "{{ url('admin/admin/update') }}/" +
                id;
            document.getElementById('username').value = name;
            document.getElementById('emailaddress').value = email;
            document.getElementById('password').required = false;
            document.getElementById('password').value = '';
        });
    });
    document.querySelectorAll('.confirm-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('formHapus').action = "{{ url('admin/admin/delete') }}/" + id;
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const submitBtn = document.getElementById('submitBtn');

        // Jika ada error validasi di backend, tombol submit akan dinonaktifkan
        @if($errors -> any())
        submitBtn.disabled = true;
        @endif

        // Menangani perubahan input untuk memeriksa apakah tombol submit bisa diaktifkan kembali
        document.querySelectorAll('input').forEach(function (input) {
            input.addEventListener('input', function () {
                // Cek jika ada error untuk setiap input
                if (document.querySelector('.is-invalid')) {
                    submitBtn.disabled = true;
                } else {
                    submitBtn.disabled = false;
                }
            });
        });
    });
</script>

@endsection
