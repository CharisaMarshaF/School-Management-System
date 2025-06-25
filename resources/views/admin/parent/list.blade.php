@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title ?? 'Parent List' }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                        <li class="breadcrumb-item active">Parents</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="card flex-fill parent-space comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Parents</h5>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form method="GET" action="{{ url('admin/parent/list') }}"
                        class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search name or email"
                                value="{{ request()->get('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fe fe-search"></i> Search
                            </button>
                            <a href="{{ url('admin/parent/list') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-rotate-ccw"></i> Reset
                            </a>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAddParent">
                        <i class="fe fe-plus"></i> Add Parent
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center table-borderless table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Occupation</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getRecord as $index => $parent)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($parent->profile_pic)
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#viewImageModal{{ $parent->id }}">
                                        <img src="{{ asset('SchoolMS_App/public/uploads/parent/' . $parent->profile_pic) }}"
                                            alt="Photo" width="40" height="40" class="rounded-circle"
                                            style="object-fit: cover;">
                                    </a>
                                    @else
                                    <span class="text-muted">No Photo</span>
                                    @endif
                                </td>
                                <td>{{ $parent->name }} {{ $parent->last_name }}</td>
                                <td>{{ $parent->email }}</td>
                                <td>{{ $parent->mobile_number }}</td>
                                <td>{{ $parent->occupation }}</td>
                                <td>{{ ucfirst($parent->gender) }}</td>
                                <td>
                                    @if($parent->status == 1)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="#" class="edit-modal" data-bs-toggle="modal"
                                        data-bs-target="#editParentModal{{ $parent->id }}">
                                        <i class="fe fe-edit text-primary"></i>
                                    </a>

                                    <a href="{{ url('admin/parent/delete/'.$parent->id) }}"
                                        onclick="return confirm('Delete this parent?')">
                                        <i class="fe fe-trash-2 text-danger"></i>
                                    </a>

                                    <a href="{{ url('admin/parent/add-child/' . $parent->id) }}" title="Add Related Data">
                                        <i class="fe fe-plus-circle text-success ms-2"></i>
                                    </a>
                                </td>

                            </tr>

                            <!-- Modal View Image -->
                            <div class="modal fade" id="viewImageModal{{ $parent->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('SchoolMS_App/public/uploads/parent/' . $parent->profile_pic) }}"
                                                alt="Parent Photo" class="img-fluid rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add Parent --}}
    <div class="modal fade" id="modalAddParent" tabindex="-1" aria-labelledby="modalAddParentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ url('admin/parent/insert') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddParentLabel">Add Parent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('admin.parent.form-fields', ['parent' => null])
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Parent</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Parent --}}
    <!-- Modal Edit Parent -->
    <div class="modal fade" id="editParentModal{{ $parent->id }}" tabindex="-1"
        aria-labelledby="editParentModalLabel{{ $parent->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ url('admin/parent/update/'.$parent->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Jika metode PUT --}}
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editParentModalLabel{{ $parent->id }}">Edit Parent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Masukkan form fields yang sama seperti di atas --}}
                        @include('admin.parent.form-fields', ['parent' => $parent])
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Parent</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit');
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEditParent'));
        const formEdit = document.getElementById('formEditParent');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                formEdit.action = '/admin/parent/update/' + id;

                formEdit.querySelector('input[name="name"]').value = this.getAttribute(
                    'data-name');
                formEdit.querySelector('input[name="last_name"]').value = this.getAttribute(
                    'data-last_name');
                formEdit.querySelector('input[name="email"]').value = this.getAttribute(
                    'data-email');
                formEdit.querySelector('input[name="mobile_number"]').value = this.getAttribute(
                    'data-mobile_number');
                formEdit.querySelector('input[name="occupation"]').value = this.getAttribute(
                    'data-occupation');
                formEdit.querySelector('textarea[name="address"]').value = this.getAttribute(
                    'data-address');
                formEdit.querySelector('select[name="gender"]').value = this.getAttribute(
                    'data-gender');
                formEdit.querySelector('select[name="status"]').value = this.getAttribute(
                    'data-status');

                // Clear password input on edit
                formEdit.querySelector('input[name="password"]').value = '';

                modalEdit.show();
            });
        });
    });
</script>
@endsection
