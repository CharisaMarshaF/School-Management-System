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
                        <li class="breadcrumb-item active">Teacher</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Success alert --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="card flex-fill student-space comman-shadow">
            <div class="card-header d-flex align-items-center justify-content-between">

                <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#homeworkModal"
                    onclick="openAddModal()">+ Add Homework</button>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('teacher.homework.index') }}" class="row g-2 mb-3">
                    <div class="col-md-5">
                        <select name="class_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Filter by Class --</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="subject_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Filter by Subject --</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="table-responsive">

                    <table class="table table-hover table-center table-borderless table-striped">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Homework Date</th>
                                <th>Submission Date</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($homeworks as $hw)
                            <tr>
                                <td>{{ $hw->class->name }}</td>
                                <td>{{ $hw->subject->name }}</td>
                                <td>{{ $hw->homework_date }}</td>
                                <td>{{ $hw->submission_date }}</td>
                                <td>
                                    @if($hw->document_file)
                                    <a href="{{ asset('SchoolMS_App/public/uploads/homework/' . $hw->document_file) }}"
                                        target="_blank">Download</a>
                                    @else
                                    No file
                                    @endif
                                </td>
                                <td>
                                    <!-- Detail Icon -->
                                    <a href="#" onclick='openDetailModal({{ json_encode($hw) }})' title="Detail">
                                        <i class="fe fe-eye text-info me-2"></i>
                                    </a>

                                    <!-- Edit Icon (Jika ingin aktifkan tinggal hapus komentar) -->
                                    {{-- 
    <a href="#" onclick='openEditModal({{ json_encode($hw) }})' title="Edit">
                                    <i class="fe fe-edit text-primary me-2"></i>
                                    </a>
                                    --}}

                                    <!-- Delete Form -->
                                    <form id="delete-form-{{ $hw->id }}"
                                        action="{{ route('teacher.homework.destroy', $hw->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="#"
                                        onclick="if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $hw->id }}').submit();"
                                        title="Delete">
                                        <i class="fe fe-trash-2 text-danger me-2"></i>
                                    </a>

                                    <!-- Submitted Teacher Icon -->
                                    <a href="{{ route('homework.submitted.teacher', $hw->id) }}" class="text-success"
                                        title="Submitted Teacher">
                                        <i class="fe fe-check-circle me-2"></i>
                                    </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No homework found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="homeworkModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="homeworkForm" method="POST" action="{{ route('teacher.homework.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Homework</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @include('teacher.homework.form-fields', ['isEdit' => false])
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Save</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editHomeworkModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="editHomeworkForm" method="POST" enctype="multipart/form-data"
                    data-action-url="{{ url('homework') }}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Homework</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            @include('teacher.homework.form-fields', ['isEdit' => true])
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Update</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Homework Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Class:</strong> <span id="detail_class"></span></p>
                        <p><strong>Subject:</strong> <span id="detail_subject"></span></p>
                        <p><strong>Homework Date:</strong> <span id="detail_hw_date"></span></p>
                        <p><strong>Submission Date:</strong> <span id="detail_sub_date"></span></p>
                        <p><strong>Description:</strong></p>
                        <p id="detail_description"></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function openAddModal() {
        $('#homeworkForm')[0].reset();
        $('#class_id').prop('disabled', false);
        $('#subject_id').prop('disabled', false).html('<option value="">Select Subject</option>');
    }

    function openEditModal(hw) {
        let form = $('#editHomeworkForm');
        let baseUrl = form.data('action-url');
        form.attr('action', `${baseUrl}/${hw.id}`);

        form.find('#class_id').val(hw.class_id).prop('disabled', true);
        form.find('#homework_date').val(hw.homework_date);
        form.find('#submission_date').val(hw.submission_date);
        form.find('#description').val(hw.description);
        fetchSubjects(hw.subject_id, true, '#editHomeworkForm');

        new bootstrap.Modal(document.getElementById('editHomeworkModal')).show();
    }


    function openDetailModal(hw) {
        $('#detail_class').text(hw.class.name);
        $('#detail_subject').text(hw.subject.name);
        $('#detail_hw_date').text(hw.homework_date);
        $('#detail_sub_date').text(hw.submission_date);
        $('#detail_description').text(hw.description);
        new bootstrap.Modal(document.getElementById('detailModal')).show();
    }

    function fetchSubjects(selectedId = null, disabled = false, formSelector = '') {
        let classId = $(formSelector + ' #class_id').val();
        if (!classId) {
            $(formSelector + ' #subject_id').html('<option value="">Select Subject</option>');
            return;
        }

        $.ajax({
            url: "{{ url('teacher/get-subjects') }}/" + classId,
            type: 'GET',
            success: function (subjects) {
                let options = '<option value="">Select Subject</option>';
                subjects.forEach(subject => {
                    let selected = (selectedId && selectedId == subject.id) ? 'selected' :
                        '';
                    options +=
                        `<option value="${subject.id}" ${selected}>${subject.name}</option>`;
                });
                $(formSelector + ' #subject_id').html(options);
                if (disabled) {
                    $(formSelector + ' #subject_id').prop('disabled', true);
                } else {
                    $(formSelector + ' #subject_id').prop('disabled', false);
                }
            }
        });
    }
</script>
@endsection
