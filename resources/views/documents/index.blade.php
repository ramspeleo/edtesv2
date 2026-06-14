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
        background: #003366;
        border-color: #003366;
        color: #fff;
        font-weight: 600;
    }

    .btn-gov-primary:hover {
        background: #00264d;
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

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">

        <div>
            <h3 class="gov-page-title mb-1">
                Document Management
            </h3>

            <div class="gov-divider"></div>

            <small class="gov-subtitle d-block mt-2">
                Manage registered documents, monitor routing activities, and track document status across offices.
            </small>
        </div>

        <a href="{{ route('documents.create') }}"
           class="btn btn-gov-primary px-4">
            <i class="bi bi-file-earmark-plus-fill me-1"></i>
            Register Document
        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    {{-- Main Card --}}
    <div class="card gov-card shadow-sm">

        <div class="gov-card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-folder2-open me-2"></i>
                Registered Documents
            </span>

            <small class="fw-normal">
                Document Tracking and Monitoring
            </small>
        </div>

        <div class="card-body bg-white">

            <div class="alert alert-light border mb-4">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                View, search, and monitor document records including routing history,
                current office assignment, and processing status.
            </div>

            <div class="table-responsive">
                <table id="documentsTable"
                       class="table table-bordered table-hover align-middle w-100 mb-0">

                    <thead>
                        <tr>
                            <th>Document No.</th>
                            <th>Tracking No.</th>
                            <th>Subject</th>
                            <th>Document Type</th>
                            <th>Current Office</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="140">Action</th>
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

    $('#documentsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,

        ajax: "{{ route('documents.documentAjaxData') }}",

        columns: [
            { data: 'document_number', name: 'document_number' },
            { data: 'tracking_number', name: 'tracking_number' },
            { data: 'subject', name: 'subject' },
            {
                data: 'document_type',
                name: 'document_type',
                orderable: false,
                searchable: false
            },
            {
                data: 'office',
                name: 'office',
                orderable: false,
                searchable: false
            },
            {
                data: 'status_badge',
                name: 'status',
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
        order: [[0, 'desc']],

        language: {
            processing: 'Loading document records...',
            search: 'Search document:',
            lengthMenu: 'Show _MENU_ records',
            info: 'Showing _START_ to _END_ of _TOTAL_ documents',
            infoEmpty: 'No document records available',
            zeroRecords: 'No matching document records found',
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        }
    });

});
</script>
@endpush