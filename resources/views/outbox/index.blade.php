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
            <h3 class="gov-page-title mb-1">
                My Outbox
            </h3>

            <div class="gov-divider"></div>

            <small class="gov-subtitle d-block mt-2">
                Monitor documents routed from your office and track their delivery and processing status.
            </small>
        </div>

        <span class="gov-badge">
            <i class="bi bi-send-fill me-1"></i>
            Outgoing Documents
        </span>

    </div>

    <div class="card gov-card shadow-sm">

        <div class="gov-card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-box-arrow-up-right me-2"></i>
                Outgoing Document Registry
            </span>

            <small class="fw-normal">
                Document Routing and Monitoring
            </small>
        </div>

        <div class="card-body bg-white">

            <div class="alert alert-light border mb-4">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                This registry contains documents transmitted from your office.
                Track routing history, receiving status, and pending actions of recipient offices.
            </div>

            <div class="table-responsive">
                <table id="outboxTable"
                       class="table table-bordered table-hover align-middle w-100 mb-0">

                    <thead>
                        <tr>
                            <th>Document No.</th>
                            <th>Document Subject</th>
                            <th>Originating Office</th>
                            <th>Destination Office</th>
                            <th>Action Required</th>
                            <th>Date Routed</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="120">
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

    $('#outboxTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,

        ajax: "{{ route('outbox.ajaxData') }}",

        columns: [
            { data: 'document_number', name: 'document_number' },
            { data: 'subject', name: 'subject' },
            {
                data: 'from_office',
                name: 'from_office',
                orderable: false
            },
            {
                data: 'to_office',
                name: 'to_office',
                orderable: false
            },
            {
                data: 'action_required',
                name: 'action_required'
            },
            {
                data: 'routed_at',
                name: 'routed_at'
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

        order: [[5, 'desc']],

        language: {
            processing: 'Loading outgoing documents...',
            search: 'Search outbox:',
            lengthMenu: 'Show _MENU_ records',
            info: 'Showing _START_ to _END_ of _TOTAL_ outgoing documents',
            infoEmpty: 'No outgoing documents available',
            emptyTable: 'No documents have been routed from your office.',
            zeroRecords: 'No matching outgoing documents found.',
            paginate: {
                previous: 'Previous',
                next: 'Next'
            }
        }
    });

});
</script>
@endpush