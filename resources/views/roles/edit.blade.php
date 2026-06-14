@extends('layouts.app')

@section('content')
<style>
    .gov-page-title {
        color: #003366;
        font-weight: 700;
    }

    .gov-subtitle {
        color: #6c757d;
        font-size: .9rem;
    }

    .gov-divider {
        width: 70px;
        height: 4px;
        background: #f7c948;
        border-radius: 10px;
        margin-top: 8px;
    }

    .gov-card {
        border: 1px solid #d9e2ec;
        border-radius: 10px;
        overflow: hidden;
    }

    .gov-card-header {
        background: linear-gradient(90deg, #003366, #0055a5);
        color: #fff;
        padding: 1rem 1.25rem;
        font-weight: 600;
    }

    .btn-gov-primary {
        background-color: #003366;
        border-color: #003366;
        color: #fff;
        font-weight: 600;
    }

    .btn-gov-primary:hover {
        background-color: #00264d;
        border-color: #00264d;
        color: #fff;
    }

    .permission-group-title {
        color: #003366;
        font-weight: 700;
        font-size: .85rem;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: .5rem;
        margin-bottom: .75rem;
    }

    .permission-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        height: 100%;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">
        <div>
            <h3 class="gov-page-title mb-1">Edit Role</h3>
            <div class="gov-divider"></div>
            <small class="gov-subtitle d-block mt-2">
                Update role details and assigned permissions.
            </small>
        </div>

        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary px-4">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Roles
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $selectedPermissions = old(
            'permissions',
            $role->permissions->pluck('name')->toArray()
        );

        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0] ?? 'general';
        });
    @endphp

    <form method="POST" action="{{ route('roles.update', $role->id) }}">
        @csrf
        @method('PUT')

        <div class="card gov-card shadow-sm mb-4">
            <div class="gov-card-header">
                <i class="bi bi-shield-lock-fill me-2"></i>
                Role Information
            </div>

            <div class="card-body bg-white">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Role Name</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $role->name) }}"
                               required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Guard Name</label>
                        <input type="text"
                               name="guard_name"
                               class="form-control @error('guard_name') is-invalid @enderror"
                               value="{{ old('guard_name', $role->guard_name ?? 'web') }}"
                               required>

                        @error('guard_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Describe what this role is allowed to do.">{{ old('description', $role->description ?? '') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="card gov-card shadow-sm">
            <div class="gov-card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-key-fill me-2"></i>
                    Assigned Permissions
                </span>

                <button type="button"
                        class="btn btn-sm btn-warning fw-semibold"
                        data-bs-toggle="modal"
                        data-bs-target="#addPermissionModal">
                    <i class="bi bi-plus-circle"></i>
                    Add Permission
                </button>
            </div>

            <div class="card-body bg-white">
                <div class="row g-3">
                    @forelse($groupedPermissions as $module => $modulePermissions)
                        <div class="col-md-4">
                            <div class="permission-box">
                                <div class="permission-group-title">
                                    {{ ucfirst($module) }} Permissions
                                </div>

                                @foreach($modulePermissions as $permission)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               id="permission_{{ $permission->id }}"
                                               {{ in_array($permission->name, $selectedPermissions) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light border mb-0">
                                No permissions available.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="card-footer bg-light text-end">
                <a href="{{ route('roles.index') }}" class="btn btn-light border">
                    Cancel
                </a>

                <button type="submit" class="btn btn-gov-primary px-4">
                    <i class="bi bi-save me-1"></i>
                    Update Role
                </button>
            </div>
        </div>

        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header" style="background:#003366; color:#fff;">
                        <h5 class="modal-title">
                            <i class="bi bi-key-fill me-1"></i>
                            Add New Permission
                        </h5>

                        <button type="button"
                                class="btn-close btn-close-white"
                                data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <label class="form-label fw-semibold">Permission Name</label>

                        <input type="text"
                               name="new_permission"
                               class="form-control"
                               placeholder="Example: documents.approve">

                        <div class="form-check mt-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="assign_new_permission"
                                   value="1"
                                   id="assign_new_permission"
                                   checked>

                            <label class="form-check-label" for="assign_new_permission">
                                Assign this permission to this role after creating
                            </label>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Use format like documents.view, reports.export, users.create
                        </small>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                                name="save_type"
                                value="add_permission"
                                class="btn btn-gov-primary">
                            <i class="bi bi-plus-circle"></i>
                            Add Permission
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </form>

</div>
@endsection