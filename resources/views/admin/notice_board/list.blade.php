@extends('layout.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">{{ $header_title }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Notice Board</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Card -->
    <div class="row">
        <div class="card p-3 comman-shadow">
            <!-- Add Button -->
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Notice</button>
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="title" class="form-control" placeholder="Title"
                        value="{{ request('title') }}">
                    <input type="date" name="notice_date" class="form-control" value="{{ request('notice_date') }}">
                    <input type="date" name="publish_date" class="form-control" value="{{ request('publish_date') }}">
                    <button class="btn btn-secondary">Search</button>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-center table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Notice Date</th>
                            <th>Publish Date</th>
                            <th>Message To</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notices as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->notice_date }}</td>
                            <td>{{ $item->publish_date }}</td>
                            <td>
                                @foreach ($item->recipients as $recipient)
                                <span class="badge bg-info text-dark me-1">
                                    {{ ['','Admin','Teacher','Student','Parent'][$recipient->message_to] ?? 'Unknown' }}
                                </span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <!-- Delete Icon -->
                                <form action="{{ route('notice_board.destroy', $item->id) }}" method="POST" style="display:inline-block;"
      onsubmit="return confirm('Are you sure you want to delete this notice?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-danger" style="border:none;">
        <i class="fe fe-trash-2"></i>
    </button>
</form>


                                <!-- Edit Icon -->
                                <a href="#" class="edit-modal" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $item->id }}">
                                    <i class="fe fe-edit text-primary"></i>
                                </a>
                            </td>

                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('notice_board.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Notice</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" name="title" class="form-control mb-2"
                                                placeholder="Title" value="{{ $item->title }}" required>
                                            <input type="date" name="notice_date" class="form-control mb-2"
                                                value="{{ $item->notice_date }}" required>
                                            <input type="date" name="publish_date" class="form-control mb-2"
                                                value="{{ $item->publish_date }}" required>
                                            <textarea name="message" class="form-control mb-2" rows="3"
                                                required>{{ $item->message }}</textarea>
                                            <label>Message To:</label><br>
                                            @foreach ([2 => 'Teacher', 3 => 'Student', 4 => 'Parent'] as $val => $label)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="message_to[]"
                                                    value="{{ $val }}"
                                                    {{ in_array($val, $item->recipients->pluck('message_to')->toArray()) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $label }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No notices found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('notice_board.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Notice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
                        <input type="date" name="notice_date" class="form-control mb-2" required>
                        <input type="date" name="publish_date" class="form-control mb-2" required>
                        <textarea name="message" class="form-control mb-2" rows="3" placeholder="Message"
                            required></textarea>
                        <label>Message To:</label><br>
                        @foreach ([2 => 'Teacher', 3 => 'Student', 4 => 'Parent'] as $val => $label)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="message_to[]" value="{{ $val }}">
                            <label class="form-check-label">{{ $label }}</label>
                        </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this notice?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.confirm-delete').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const form = document.getElementById('deleteForm');
                form.setAttribute('action', '/notice-board/' + id); // Ganti sesuai route resource-mu
            });
        });
    });
</script>
@endsection
