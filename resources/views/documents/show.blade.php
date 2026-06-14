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

    .gov-section-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }

    .gov-info-label {
        color: #64748b;
        font-size: .78rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: .03em;
        margin-bottom: .25rem;
    }

    .gov-info-value {
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 1rem;
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

    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">
        <div>
            <h3 class="gov-page-title mb-1">Document Details</h3>
            <div class="gov-divider"></div>
            <small class="gov-subtitle d-block mt-2">
                View document information, routing status, processing actions, and official timeline.
            </small>
        </div>

        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Document Registry
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

    <div class="card gov-card shadow-sm mb-4">
        <div class="gov-card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-file-earmark-text-fill me-2"></i>
                Official Document Information
            </span>

            <span class="badge bg-light text-dark">
                {{ strtoupper(str_replace('_', ' ', $document->status)) }}
            </span>
        </div>

        <div class="card-body bg-white">

            <div class="row">
                <div class="col-lg-6">
                    <div class="gov-info-label">Document No.</div>
                    <div class="gov-info-value">{{ $document->document_number }}</div>

                    <div class="gov-info-label">Tracking No.</div>
                    <div class="gov-info-value">{{ $document->tracking_number }}</div>

                    <div class="gov-info-label">Reference No.</div>
                    <div class="gov-info-value">{{ $document->reference_number ?? 'N/A' }}</div>

                    <div class="gov-info-label">Document Type</div>
                    <div class="gov-info-value">{{ $document->documentType->name ?? 'N/A' }}</div>
                </div>

                <div class="col-lg-6">
                    <div class="gov-info-label">Originating Office</div>
                    <div class="gov-info-value">{{ $document->originOffice->office_name ?? 'N/A' }}</div>

                    <div class="gov-info-label">Current Custodian Office</div>
                    <div class="gov-info-value">{{ $document->currentOffice->office_name ?? 'N/A' }}</div>

                    <div class="gov-info-label">Processing Priority</div>
                    <div class="gov-info-value">{{ strtoupper($document->priority ?? 'NORMAL') }}</div>

                    <div class="gov-info-label">Security Classification</div>
                    <div class="gov-info-value">{{ strtoupper($document->confidentiality ?? 'INTERNAL') }}</div>
                </div>

                <div class="col-12">
                    <hr>

                    <div class="gov-info-label">Document Subject</div>
                    <div class="gov-info-value">{{ $document->subject }}</div>

                    <div class="gov-info-label">Remarks / Description</div>
                    <div class="gov-info-value mb-0">{{ $document->description ?? 'N/A' }}</div>
                </div>
            </div>

        </div>
    </div>

    <div class="card gov-section-card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('documents.coverSheet', $document) }}"
                   target="_blank"
                   class="btn btn-outline-dark">
                    <i class="bi bi-printer-fill me-1"></i>
                    Print Cover Sheet
                </a>

                @if($document->status === 'received')
                    <form method="POST"
                          action="{{ route('documents.sign', $document) }}"
                          class="d-inline">
                        @csrf

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check2-circle me-1"></i>
                            Approve / Sign
                        </button>
                    </form>
                @endif

                @if(!in_array($document->status, ['in_route', 'completed']))
                    <a href="{{ route('documents.route.create', $document) }}"
                       class="btn btn-gov-primary">
                        <i class="bi bi-send-fill me-1"></i>
                        Route Document
                    </a>
                @endif

            </div>
        </div>
    </div>

    <div class="card gov-card shadow-sm">
        <div class="gov-card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-clock-history me-2"></i>
                Routing Timeline
            </span>

            <small class="fw-normal">
                Document Movement History
            </small>
        </div>

        <div class="card-body bg-white">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date Routed</th>
                            <th>From Office</th>
                            <th>To Office</th>
                            <th>Action Required</th>
                            <th>Remarks</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($document->routes as $route)
                            <tr>
                                <td>
                                    {{ $route->routed_at ? $route->routed_at->format('M d, Y h:i A') : 'N/A' }}
                                </td>
                                <td>{{ $route->fromOffice->office_name ?? 'N/A' }}</td>
                                <td>{{ $route->toOffice->office_name ?? 'N/A' }}</td>
                                <td>{{ $route->action_required ?? 'N/A' }}</td>
                                <td>{{ $route->remarks ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        {{ strtoupper(str_replace('_', ' ', $route->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    No routing history available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection