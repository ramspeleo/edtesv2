@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">
                <i class="bi bi-pencil-square text-warning"></i>
                Edit User
            </h3>
            <small class="text-muted">
                Update EDTES user account
            </small>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Users
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>
                <i class="bi bi-exclamation-triangle-fill"></i>
                Validation Error
            </strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('users.update', $user->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        {{-- PERSONAL INFORMATION --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <strong>
                    <i class="bi bi-person-vcard-fill"></i>
                    Personal Information
                </strong>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-3 text-center">
                        <img id="photoPreview"
                             src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('assets/images/default-user.png') }}"
                             class="img-thumbnail rounded-circle shadow-sm mb-2"
                             style="width:150px;height:150px;object-fit:cover;"
                             alt="User Photo">

                        <input type="file"
                               name="profile_photo"
                               id="profilePhoto"
                               class="form-control">
                    </div>

                    <div class="col-md-9">
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text"
                                       name="fname"
                                       class="form-control"
                                       value="{{ old('fname', $user->fname) }}"
                                       required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text"
                                       name="mname"
                                       class="form-control"
                                       value="{{ old('mname', $user->mname) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text"
                                       name="lname"
                                       class="form-control"
                                       value="{{ old('lname', $user->lname) }}"
                                       required>
                            </div>

                            <div class="col-md-1 mb-3">
                                <label class="form-label">Ext.</label>
                                <input type="text"
                                       name="extension"
                                       class="form-control"
                                       value="{{ old('extension', $user->extension) }}">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text"
                                       name="mobile_no"
                                       class="form-control"
                                       value="{{ old('mobile_no', $user->mobile_no) }}"
                                       placeholder="09XXXXXXXXX">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Employee Number</label>
                                <input type="number"
                                       name="emp_no"
                                       class="form-control"
                                       value="{{ old('emp_no', $user->emp_no) }}">
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- EMPLOYMENT INFORMATION --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <strong>
                    <i class="bi bi-building-fill"></i>
                    Employment Information
                </strong>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Office</label>
                        <select name="office_id" class="form-select" required>
                            <option value="">Select Office</option>

                            @foreach($offices as $office)
                                <option value="{{ $office->id }}"
                                    {{ old('office_id', $user->office_id) == $office->id ? 'selected' : '' }}>
                                    {{ $office->office_code }} - {{ $office->office_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Employment Type</label>
                        <select name="emp_type" class="form-select">
                            <option value="Permanent"
                                {{ old('emp_type', $user->emp_type) == 'Permanent' ? 'selected' : '' }}>
                                Permanent
                            </option>

                            <option value="Contractual"
                                {{ old('emp_type', $user->emp_type) == 'Contractual' ? 'selected' : '' }}>
                                Contractual
                            </option>

                            <option value="Job Order"
                                {{ old('emp_type', $user->emp_type) == 'Job Order' ? 'selected' : '' }}>
                                Job Order
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Position Title</label>
                        <input type="text"
                               name="emp_title"
                               class="form-control"
                               value="{{ old('emp_title', $user->emp_title) }}">
                    </div>

                </div>
            </div>
        </div>

        {{-- ACCOUNT INFORMATION --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <strong>
                    <i class="bi bi-shield-lock-fill"></i>
                    Account Information
                </strong>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">Select Role</option>

                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password"
                               name="password"
                               class="form-control">
                        <small class="text-muted">
                            Leave blank if unchanged.
                        </small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control">
                    </div>

                </div>
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i>
                Cancel
            </a>

            <button type="submit" class="btn btn-warning">
                <i class="bi bi-check-circle-fill"></i>
                Update User
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('profilePhoto').addEventListener('change', function(e) {
    const file = e.target.files[0];

    if (file) {
        document.getElementById('photoPreview').src = URL.createObjectURL(file);
    }
});
</script>
@endpush