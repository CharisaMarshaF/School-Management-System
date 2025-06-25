<div class="row g-3">
    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="name" value="{{ $parent->name ?? '' }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Last Name</label>
        <input type="text" name="last_name" value="{{ $parent->last_name ?? '' }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Email</label>
        <input type="email" name="email" value="{{ $parent->email ?? '' }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Password</label>
        <input type="password" name="password" class="form-control" {{ isset($parent) ? '' : 'required' }}>
    </div>
    <div class="col-md-6">
        <label>Mobile Number</label>
        <input type="text" name="mobile_number" value="{{ $parent->mobile_number ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Occupation</label>
        <input type="text" name="occupation" value="{{ $parent->occupation ?? '' }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Address</label>
        <textarea name="address" class="form-control" rows="2">{{ $parent->address ?? '' }}</textarea>
    </div>
    <div class="col-md-6">
        <label>Gender</label>
        <select name="gender" class="form-control">
            <option value="">-- Select Gender --</option>
            <option value="Male" {{ (isset($parent) && $parent->gender == 'Male') ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ (isset($parent) && $parent->gender == 'Female') ? 'selected' : '' }}>Female
            </option>
        </select>
    </div>
    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" {{ (isset($parent) && $parent->status == 1) ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (isset($parent) && $parent->status == 0) ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="mb-3 col-12">
        <label for="profile_pic" class="form-label">Profile Picture</label>
        <input type="file" class="form-control" name="profile_pic" accept="image/*">
        @if(isset($parent) && $parent->profile_pic)
        <img src="{{ asset('uploads/parent/' . $parent->profile_pic) }}" alt="Profile Pic" height="80" class="mt-2">
        @endif
    </div>
</div>
