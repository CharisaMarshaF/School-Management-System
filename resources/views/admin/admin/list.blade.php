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
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Star Students</h5>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Form Pencarian -->
                    <form method="GET" action="{{ url('admin/admin/list') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name or email"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/admin/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>

                    <!-- Tombol Tambah -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup-modal"
                        id="tambah-admin">
                        <i class="fe fe-plus"></i> Add New Admin
                    </button>
                </div>

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
                            @forelse($getRecord as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->name }}</td>
                                <td class="text-center">{{ $value->email }}</td>
                                <td class="text-center">{{ $value->created_at }}</td>
                                <td class="text-center">
                                    <form action="{{ url('admin/admin/delete/' . $value->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
        <i class="fe fe-trash-2 text-danger"></i>
    </button>
</form>

                                    {{-- <a href="#" class="edit-modal" data-bs-toggle="modal"
                                        data-bs-target="#signup-modal" data-id="{{ $value->id }}"
                                        data-name="{{ $value->name }}" data-email="{{ $value->email }}">
                                        <i class="fe fe-edit text-primary"></i>
                                    </a> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Update -->
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
                        <input class="form-control" name="name" type="text" id="username" required
                            placeholder="Michael Zenaty" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">last_name</label>
                        <input class="form-control @error('last_name') is-invalid @enderror" name="last_name" type="text"
                            id="last_name" required placeholder="michael.zenaty" value="{{ old('last_name') }}">
                        @if ($errors->has('last_name'))
                        <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="emailaddress" class="form-label">Email address</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                            id="emailaddress" required placeholder="john@deo.com" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" required id="password"
                            placeholder="Enter your password">
                    </div>
                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit" id="submitBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
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
        document.getElementById('password').value = '';
    });

    document.querySelectorAll('.edit-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
                        const name = this.getAttribute('data-last_name');
            const email = this.getAttribute('data-email');
            document.querySelector('#signup-modal form').action = "{{ url('admin/admin/update') }}/" + id;
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
        @if($errors->any())
        submitBtn.disabled = true;
        @endif
        document.querySelectorAll('input').forEach(function (input) {
            input.addEventListener('input', function () {
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
