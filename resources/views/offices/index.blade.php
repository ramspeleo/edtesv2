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

    .gov-divider {
        height: 4px;
        width: 70px;
        background-color: #f7c948;
        border-radius: 10px;
        margin-top: 8px;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">
        <div>
            <h3 class="mb-1 gov-page-title">Offices</h3>
            <div class="gov-divider"></div>
            <small class="gov-subtitle d-block mt-2">
                Manage office records, classifications, status, and organizational hierarchy.
            </small>
        </div>

        <a href="{{ route('offices.create') }}" class="btn btn-gov-primary px-4">
            <i class="fas fa-plus-circle me-1"></i>
            Add Office
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-1"></i>
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
                <i class="fas fa-building me-2"></i>
                Office Directory
            </span>
            <small class="fw-normal">Government Office Management</small>
        </div>

        <div class="card-body bg-white">

            <div class="table-responsive">
                <table id="officesTable"
                       class="table table-bordered table-hover align-middle w-100 mb-0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Office Name</th>
                            <th>Type</th>
                            <th>Parent Office</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="180">Action</th>
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
    $('#officesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,

        ajax: "{{ route('offices.ajaxData') }}",

        columns: [
            { data: 'office_code', name: 'office_code' },
            { data: 'office_name', name: 'office_name' },
            { data: 'office_type', name: 'office_type' },
            { data: 'parent_office', name: 'parent_office', orderable: false },
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

        pageLength: 10,
        order: [[1, 'asc']],

        language: {
            processing: 'Loading office records...',
            search: 'Search office:',
            lengthMenu: 'Show _MENU_ records',
            info: 'Showing _START_ to _END_ of _TOTAL_ offices',
            infoEmpty: 'No office records available',
            zeroRecords: 'No matching office records found',
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        }
    });
});
</script>
@endpush