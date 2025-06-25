<div class="row g-3">
    <div class="col-md-6">
        <label>First Name</label>
        <input type="text" name="name" class="form-control" value="{{ $teacher->name ?? '' }}" required>
    </div>
    <div class="col-md-6">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ $teacher->last_name ?? '' }}" required>
    </div>
    <div class="col-md-6">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $teacher->email ?? '' }}" required>
    </div>
    <div class="col-md-6">
        <label>Password</label>
        <input type="password" name="password" class="form-control" {{ isset($teacher) ? '' : 'required' }}>
    </div>
    <div class="col-md-6">
        <label>Mobile Number</label>
        <input type="text" name="mobile_number" class="form-control"
            value="{{ $teacher->mobile_number ?? '' }}">
    </div>
    <div class="col-md-6">
        <label>Gender</label>
        <select name="gender" class="form-control">
            <option value="">-- Select --</option>
            <option value="Male" {{ (isset($teacher) && $teacher->gender == 'Male') ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ (isset($teacher) && $teacher->gender == 'Female') ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    <div class="col-md-6">
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="{{ $teacher->date_of_birth ?? '' }}">
    </div>
    <div class="col-md-6">
        <label>Date of Joining</label>
        <input type="date" name="date_of_joining" class="form-control" value="{{ $teacher->date_of_joining ?? '' }}">
    </div>
    <div class="col-md-6">
        <label>Qualification</label>
        <input type="text" name="qualification" class="form-control" value="{{ $teacher->qualification ?? '' }}">
    </div>
    <div class="col-md-6">
        <label>Work Experience</label>
        <input type="text" name="work_experience" class="form-control" value="{{ $teacher->work_experience ?? '' }}">
    </div>
    <div class="col-md-6">
        <label>Marital Status</label>
        <select name="marital_status" class="form-control">
            <option value="">-- Select --</option>
            <option value="Married" {{ (isset($teacher) && $teacher->marital_status == 'Married') ? 'selected' : '' }}>Married</option>
            <option value="Single" {{ (isset($teacher) && $teacher->marital_status == 'Single') ? 'selected' : '' }}>Single</option>
        </select>
    </div>
    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="0" {{ (isset($teacher) && $teacher->status == 0) ? 'selected' : '' }}>Active</option>
            <option value="1" {{ (isset($teacher) && $teacher->status == 1) ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="col-md-6">
        <label>Address</label>
        <textarea name="address" class="form-control">{{ $teacher->address ?? '' }}</textarea>
    </div>
    <div class="col-md-6">
        <label>Permanent Address</label>
        <textarea name="permanent_address" class="form-control">{{ $teacher->permanent_address ?? '' }}</textarea>
    </div>
    <div class="col-md-12">
        <label>Note</label>
        <textarea name="note" class="form-control">{{ $teacher->note ?? '' }}</textarea>
    </div>
    <div class="col-md-12">
        <label>Profile Picture</label>
        <input type="file" name="profile_pic" class="form-control" accept="image/*">
        @if(isset($teacher) && $teacher->profile_pic)
        <img src="{{ asset('SchoolMS_App/public/uploads/teacher/' . $teacher->profile_pic) }}" height="80" class="mt-2">
        @endif
    </div>
</div>
