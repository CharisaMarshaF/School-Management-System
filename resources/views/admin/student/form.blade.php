<div class="row g-3">
    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="name" value="{{ $student->name ?? '' }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Last Name</label>
        <input type="text" name="last_name" value="{{ $student->last_name ?? '' }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Email</label>
        <input type="email" name="email" value="{{ $student->email ?? '' }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Password</label>
        <input type="password" name="password" class="form-control" {{ isset($student) ? '' : 'required' }}>
    </div>
    <div class="col-md-6">
        <label>Admission Number</label>
        <input type="text" name="admission_number" value="{{ $student->admission_number ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Roll Number</label>
        <input type="text" name="role_number" value="{{ $student->role_number ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Class</label>
        <select name="class_id" class="form-control">
            <option value="">-- Select Class --</option>
            @foreach (\App\Models\ClassModel::all() as $class)
                <option value="{{ $class->id }}" {{ isset($student) && $student->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label>Gender</label>
        <select name="gender" class="form-control">
            <option value="Male" {{ (isset($student) && $student->gender == 'Male') ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ (isset($student) && $student->gender == 'Female') ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    <div class="col-md-6">
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ $student->date_of_birth ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Mobile Number</label>
        <input type="text" name="mobile_number" value="{{ $student->mobile_number ?? '' }}" class="form-control">
    </div>
   
    <div class="col-md-6">
        <label>Religion</label>
        <input type="text" name="religion" value="{{ $student->religion ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Admission Date</label>
        <input type="date" name="admission_date" value="{{ $student->admission_date ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Blood Group</label>
        <input type="text" name="blood_group" value="{{ $student->blood_group ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Height</label>
        <input type="text" name="height" value="{{ $student->height ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Weight</label>
        <input type="text" name="weight" value="{{ $student->weight ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="0" {{ (isset($student) && $student->status == 0 ) ? 'selected' : '' }}>Active</option>
            <option value="1" {{ (isset($student) && $student->status == 1 ) ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
     <div class="mb-3">
        <label>Address</label>
        <textarea name="address" class="form-control" rows="2">{{ $student->address ?? '' }}</textarea>
    </div>
     <div class="mb-3">
        <label for="profile_pic" class="form-label">Student Picture</label>
        <input type="file" class="form-control" name="profile_pic" accept="image/*">
        
        @if(isset($student) && $student->profile_pic)
            <img src="{{ asset('SchoolMS_App/public/uploads/students/'.$student->profile_pic) }}" alt="Picture" height="80" class="mt-2">
        @endif
    </div>

</div>
