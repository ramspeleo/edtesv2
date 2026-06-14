@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">
                <i class="bi bi-person-plus-fill text-primary"></i>
                Add User
            </h3>
            <small class="text-muted">
                Create a new EDTES user account
            </small>
        </div>

        <a href="{{ route('users.index') }}"
           class="btn btn-outline-secondary">
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
          action="{{ route('users.store') }}"
          enctype="multipart/form-data">

        @csrf

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
                        src="{{ asset('assets/images/default-user.png') }}"
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
                                <label class="form-label">
                                    First Name
                                </label>

                                <input type="text"
                                       name="fname"
                                       class="form-control"
                                       value="{{ old('fname') }}"
                                       required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Middle Name
                                </label>

                                <input type="text"
                                       name="mname"
                                       class="form-control"
                                       value="{{ old('mname') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Last Name
                                </label>

                                <input type="text"
                                       name="lname"
                                       class="form-control"
                                       value="{{ old('lname') }}"
                                       required>
                            </div>

                            <div class="col-md-1 mb-3">
                                <label class="form-label">
                                    Ext.
                                </label>

                                <input type="text"
                                       name="extension"
                                       class="form-control"
                                       value="{{ old('extension') }}">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Email Address
                                </label>

                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email') }}"
                                       required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Mobile Number
                                </label>

                                <input type="text"
                                       name="mobile_no"
                                       class="form-control"
                                       placeholder="09XXXXXXXXX">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    Employee Number
                                </label>

                                <input type="number"
                                       name="emp_no"
                                       class="form-control">
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
                        <label class="form-label">
                            Office
                        </label>

                        <select name="office_id"
                                class="form-select"
                                required>
                            <option value="">
                                Select Office
                            </option>

                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">
                                    {{ $office->office_code }}
                                    -
                                    {{ $office->office_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Employment Type
                        </label>

                        <select name="emp_type"
                                class="form-select">

                            <option value="Permanent">
                                Permanent
                            </option>

                            <option value="Contractual">
                                Contractual
                            </option>

                            <option value="Job Order">
                                Job Order
                            </option>

                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Position Title
                        </label>

                        <input type="text"
                               name="emp_title"
                               class="form-control">
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
                        <label class="form-label">
                            Role
                        </label>

                        <select name="role"
                                class="form-select"
                                required>

                            <option value="">
                                Select Role
                            </option>

                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Confirm Password
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>
                    </div>

                </div>

            </div>
        </div>

        <div class="text-end">

            <a href="{{ route('users.index') }}"
               class="btn btn-outline-secondary">
                <i class="bi bi-x-circle"></i>
                Cancel
            </a>

            <button type="submit"
                    class="btn btn-primary">
                <i class="bi bi-person-check-fill"></i>
                Save User
            </button>

        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('profilePhoto')
.addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        document.getElementById('photoPreview')
            .src = URL.createObjectURL(file);

    }
});
</script>
@endpush