@extends('layouts.app')

@section('content')
<style>
    .gov-page-title {
        color: #003366;
        font-weight: 700;
    }

    .gov-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .gov-divider {
        height: 4px;
        width: 70px;
        background-color: #f7c948;
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
        font-size: 0.78rem;
        letter-spacing: 0.03em;
        vertical-align: middle;
    }

    .table tbody td {
        vertical-align: middle;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">
        <div>
            <h3 class="mb-1 gov-page-title">User Management</h3>
            <div class="gov-divider"></div>
            <small class="gov-subtitle d-block mt-2">
                Manage system users, assigned offices, access roles, and account status.
            </small>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-gov-primary px-4">
            <i class="bi bi-plus-circle-fill me-1"></i>
            Add User
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
                <i class="bi bi-people-fill me-2"></i>
                System Users
            </span>
            <small class="fw-normal">User Access Administration</small>
        </div>

        <div class="card-body bg-white">
            <div class="table-responsive">
                <table id="usersTable"
                       class="table table-bordered table-hover align-middle w-100 mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No.</th>
                            <th>Office</th>
                            <th>Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="160">Action</th>
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
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[0, 'asc']],

        ajax: "{{ route('users.ajaxData') }}",

        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'mobile_no', name: 'mobile_no' },
            { data: 'office', name: 'office', orderable: false },
            { data: 'role', name: 'role', orderable: false },
            {
                data: 'status_badge',
                name: 'is_active',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],

        language: {
            processing: 'Loading user records...',
            search: 'Search user:',
            lengthMenu: 'Show _MENU_ records',
            info: 'Showing _START_ to _END_ of _TOTAL_ users',
            infoEmpty: 'No user records available',
            zeroRecords: 'No matching user records found',
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        }
    });
});
</script>
@endpush