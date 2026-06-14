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

    .table thead th {
        background-color: #f1f5f9;
        color: #003366;
        font-weight: 700;
        text-transform: uppercase;
        font-size: .78rem;
        letter-spacing: .03em;
        vertical-align: middle;
    }

    .table tbody td {
        vertical-align: middle;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">

        <div>
            <h3 class="gov-page-title mb-1">
                Role Management
            </h3>

            <div class="gov-divider"></div>

            <small class="gov-subtitle d-block mt-2">
                Manage user access roles, permission assignments, and authorization levels within the system.
            </small>
        </div>

        <a href="{{ route('roles.create') }}"
           class="btn btn-gov-primary px-4">
            <i class="bi bi-shield-plus me-1"></i>
            Create Role
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif

    <div class="card gov-card shadow-sm">

        <div class="gov-card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-shield-lock-fill me-2"></i>
                System Roles Directory
            </span>

            <small class="fw-normal">
                Access Control Administration
            </small>
        </div>

        <div class="card-body bg-white">

            <div class="alert alert-light border mb-4">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                Define system roles and assign permissions to control access to modules,
                functions, and document processing activities.
            </div>

            <div class="table-responsive">
                <table id="rolesTable"
                       class="table table-bordered table-hover align-middle w-100 mb-0">

                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Description</th>
                            <th>Assigned Permissions</th>
                            <th class="text-center" width="160">
                                Action
                            </th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
$(function () {

    $('#rolesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,

        ajax: "{{ route('roles.ajaxData') }}",

        columns: [
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'permissions',
                name: 'permissions',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],

        pageLength: 10,
        order: [[0, 'asc']],

        language: {
            processing: 'Loading role records...',
            search: 'Search role:',
            lengthMenu: 'Show _MENU_ records',
            info: 'Showing _START_ to _END_ of _TOTAL_ roles',
            infoEmpty: 'No role records available',
            emptyTable: 'No system roles have been defined.',
            zeroRecords: 'No matching roles found.',
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        }
    });

});
</script>
@endpush