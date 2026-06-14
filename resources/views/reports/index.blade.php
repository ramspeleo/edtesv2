@extends('layouts.app')

@section('content')
<style>
    .gov-page-title {
        border-left: 6px solid #003366;
        padding-left: 14px;
        font-weight: 700;
    }
    .gov-divider {
        width: 70px;
        height: 4px;
        background: #f7c948;
        border-radius: 10px;
        margin-top: 8px;
    }

    .gov-card {
        border: 1px solid #d6d6d6;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,.06);
    }

    .gov-card .card-header {
        background: #003366;
        color: #fff;
        font-weight: 700;
        letter-spacing: .3px;
    }

    .summary-card {
        border-top: 5px solid #0038a8;
        min-height: 115px;
    }

    .summary-card h6 {
        font-size: 12px;
        text-transform: uppercase;
        color: #555;
        font-weight: 700;
    }

    .summary-card h3 {
        font-size: 30px;
        font-weight: 800;
        color: #0038a8;
    }

    .summary-card.danger {
        border-top-color: #ce1126;
    }

    .summary-card.danger h3 {
        color: #ce1126;
    }

    .table thead th {
        background: #f1f3f5;
        color: #222;
        font-size: 12px;
        text-transform: uppercase;
        vertical-align: middle;
    }

    .tracking-no {
        font-family: "Consolas", "Courier New", monospace;
        font-weight: 900;
        color: #ce1126;
        letter-spacing: -0.3px;
    }

    .btn-gov {
        background: #0038a8;
        color: #fff;
        border: none;
    }

    .btn-gov:hover {
        background: #002b80;
        color: #fff;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #333;
    }

    @media print {
        .no-print,
        .sidebar,
        .navbar,
        aside {
            display: none !important;
        }

        .container-fluid {
            width: 100%;
        }

        .card {
            box-shadow: none !important;
        }
    }
</style>

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div class="gov-page-title">
            <h4 class="mb-0 fw-bold">Reports Dashboard</h4>
            <div class="gov-divider"></div>
            <small class="text-muted">
                Electronic Document Tracking and Exchange System (EDTES)
            </small>
        </div>

        <div>
            <button class="btn btn-sm btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </button>

            <button class="btn btn-sm btn-success">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </button>

            <button onclick="window.print()" class="btn btn-sm btn-secondary">
                <i class="bi bi-printer"></i> Print
            </button>
        </div>
    </div>

    {{-- Report Navigation --}}
    <div class="row mb-4 no-print">
        <div class="col-md-4">
            <a href="{{ route('reports.index') }}" class="text-decoration-none">
                <div class="card gov-card text-center">
                    <div class="card-body">
                        <i class="bi bi-speedometer2 fs-2 text-primary"></i>
                        <h6 class="mt-2 mb-0 fw-bold">Dashboard Summary</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('reports.documents') }}" class="text-decoration-none">
                <div class="card gov-card text-center">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text fs-2 text-danger"></i>
                        <h6 class="mt-2 mb-0 fw-bold">Document Reports</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('reports.tracking') }}" class="text-decoration-none">
                <div class="card gov-card text-center">
                    <div class="card-body">
                        <i class="bi bi-clock-history fs-2 text-success"></i>
                        <h6 class="mt-2 mb-0 fw-bold">Tracking Reports</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h6>Total Documents</h6>
                    <h3>{{ $totalDocuments ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h6>Pending</h6>
                    <h3>{{ $pendingDocuments ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h6>Completed</h6>
                    <h3>{{ $completedDocuments ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card summary-card danger text-center">
                <div class="card-body">
                    <h6>Overdue</h6>
                    <h3>{{ $overdueDocuments ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h6>Received Today</h6>
                    <h3>{{ $receivedToday ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h6>Routed Today</h6>
                    <h3>{{ $routedToday ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card gov-card mb-4 no-print">
        <div class="card-header">
            <i class="bi bi-funnel"></i> Report Filters
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="filter-label">From Date</label>
                        <input type="date" name="from_date" class="form-control"
                               value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">To Date</label>
                        <input type="date" name="to_date" class="form-control"
                               value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_process" {{ request('status') == 'in_process' ? 'selected' : '' }}>In Process</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="">All Priority</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>

                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-gov">
                        <i class="bi bi-search"></i> Generate Report
                    </button>

                    <a href="{{ route('reports.index') }}" class="btn btn-light border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Document Tracking Report --}}
    <div class="card gov-card mb-4">
        <div class="card-header">
            <i class="bi bi-file-earmark-text"></i> Document Tracking Report
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Tracking No.</th>
                        <th>Document No.</th>
                        <th>Subject</th>
                        <th>Origin Office</th>
                        <th>Current Office</th>
                        <th>Status</th>
                        <th>Date Created</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($documents ?? [] as $document)
                        <tr>
                            <td>
                                <span class="tracking-no">
                                    {{ $document->tracking_number }}
                                </span>
                            </td>
                            <td>{{ $document->document_number }}</td>
                            <td>{{ $document->subject }}</td>
                            <td>{{ $document->originOffice->office_name ?? 'N/A' }}</td>
                            <td>{{ $document->currentOffice->office_name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ strtoupper(str_replace('_', ' ', $document->status)) }}
                                </span>
                            </td>
                            <td>{{ $document->created_at?->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No report records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Office Performance --}}
    <div class="card gov-card mb-4">
        <div class="card-header">
            <i class="bi bi-building"></i> Office Performance Report
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Office</th>
                        <th>Documents Received</th>
                        <th>Documents Processed</th>
                        <th>Pending</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($officeReports ?? [] as $office)
                        <tr>
                            <td class="fw-bold">{{ $office->office_name }}</td>
                            <td>{{ $office->received_count ?? 0 }}</td>
                            <td>{{ $office->processed_count ?? 0 }}</td>
                            <td>{{ $office->pending_count ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No office report available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection