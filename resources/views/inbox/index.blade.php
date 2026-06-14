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

    .gov-badge {
        background: #003366;
        color: #fff;
        border-radius: 50rem;
        padding: .55rem .85rem;
        font-size: .85rem;
        font-weight: 600;
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
            <h3 class="gov-page-title mb-1">My Inbox</h3>
            <div class="gov-divider"></div>
            <small class="gov-subtitle d-block mt-2">
                Review and receive documents routed to your office for official action.
            </small>
        </div>

        <span class="gov-badge">
            <i class="bi bi-inbox-fill me-1"></i>
            Incoming Documents
        </span>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            {{ session('error') }}

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
                <i class="bi bi-tray-fill me-2"></i>
                Incoming Document Registry
            </span>

            <small class="fw-normal">
                For Receiving and Official Action
            </small>
        </div>

        <div class="card-body bg-white">

            <div class="alert alert-light border mb-4">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                This list contains documents currently routed to your office.
                Review each document and take the appropriate receiving or routing action.
            </div>

            <div class="table-responsive">
                <table id="incomingRoutesTable"
                       class="table table-bordered table-hover align-middle w-100 mb-0">
                    <thead>
                        <tr>
                            <th>Document No.</th>
                            <th>Tracking No.</th>
                            <th>Document Subject</th>
                            <th>From Office</th>
                            <th>Action Required</th>
                            <th>Routed At</th>
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
    $('#incomingRoutesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        order: [[5, 'desc']],

        ajax: "{{ route('routes.incomingAjaxData') }}",

        columns: [
            { data: 'document_number', name: 'document_number' },
            { data: 'tracking_number', name: 'tracking_number' },
            { data: 'subject', name: 'subject' },
            {
                data: 'from_office',
                name: 'from_office',
                orderable: false,
                searchable: false
            },
            { data: 'action_required', name: 'action_required' },
            { data: 'routed_at', name: 'routed_at' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],

        language: {
            processing: 'Loading incoming documents...',
            search: 'Search inbox:',
            lengthMenu: 'Show _MENU_ records',
            info: 'Showing _START_ to _END_ of _TOTAL_ incoming documents',
            infoEmpty: 'No incoming documents available',
            emptyTable: 'No documents are currently routed to your office.',
            zeroRecords: 'No matching incoming documents found.',
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        }
    });
});
</script>
@endpush