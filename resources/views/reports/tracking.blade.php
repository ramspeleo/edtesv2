@extends('layouts.app')

@section('content')
<style>
    .gov-page-title {
        border-left: 6px solid #003366;
        font-weight: 700;
        padding-left: 14px;
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
        border-top: 5px solid #003366;
        min-height: 110px;
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

    .summary-card.success {
        border-top-color: #198754;
    }

    .summary-card.success h3 {
        color: #198754;
    }

    .summary-card.warning {
        border-top-color: #f0ad00;
    }

    .summary-card.warning h3 {
        color: #b77900;
    }

    .summary-card.danger {
        border-top-color: #ce1126;
    }

    .summary-card.danger h3 {
        color: #ce1126;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #333;
    }

    .tracking-no {
        font-family: "Consolas", "Courier New", monospace;
        font-weight: 900;
        color: #ce1126;
        letter-spacing: -0.3px;
    }

    .table thead th {
        background: #f1f3f5;
        color: #222;
        font-size: 12px;
        text-transform: uppercase;
        vertical-align: middle;
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

    @media print {
        .no-print,
        .btn,
        nav,
        aside,
        .sidebar,
        .navbar {
            display: none !important;
        }

        body {
            background: #fff;
        }

        .card {
            border: none;
            box-shadow: none !important;
        }

        table {
            font-size: 11px;
        }
    }
</style>

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div class="gov-page-title">
            <h4 class="mb-0 fw-bold">Tracking Report</h4>
            <small class="text-muted">
                Document routing and movement history
            </small>
        </div>

        <div>
            <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-speedometer2"></i> Reports Dashboard
            </a>

            <a href="{{ route('reports.documents') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-file-earmark-text"></i> Document Report
            </a>

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
                <div class="card gov-card text-center border-primary">
                    <div class="card-body">
                        <i class="bi bi-clock-history fs-2 text-success"></i>
                        <h6 class="mt-2 mb-0 fw-bold">Tracking Reports</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card gov-card mb-4 no-print">
        <div class="card-header">
            <i class="bi bi-funnel"></i> Tracking Report Filters
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('reports.tracking') }}">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="filter-label">From Date</label>
                        <input type="date"
                               name="from_date"
                               class="form-control"
                               value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">To Date</label>
                        <input type="date"
                               name="to_date"
                               class="form-control"
                               value="{{ request('to_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">Tracking Number</label>
                        <input type="text"
                               name="tracking_number"
                               class="form-control"
                               placeholder="Search tracking no."
                               value="{{ request('tracking_number') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="routed" {{ request('status') == 'routed' ? 'selected' : '' }}>Routed</option>
                            <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                    </div>

                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-gov">
                        <i class="bi bi-search"></i> Generate Report
                    </button>

                    <a href="{{ route('reports.tracking') }}" class="btn btn-light border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h6>Total Routed Documents</h6>
                    <h3>{{ $totalRouted ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card success text-center">
                <div class="card-body">
                    <h6>Received</h6>
                    <h3>{{ $totalReceived ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card warning text-center">
                <div class="card-body">
                    <h6>Pending Receipt</h6>
                    <h3>{{ $pendingReceipt ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card summary-card danger text-center">
                <div class="card-body">
                    <h6>Returned</h6>
                    <h3>{{ $totalReturned ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tracking Table --}}
    <div class="card gov-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-clock-history"></i> Routing History
            </span>
            <small>
                Generated: {{ now()->format('M d, Y h:i A') }}
            </small>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="13%">Date Routed</th>
                        <th width="14%">Tracking No.</th>
                        <th width="20%">Subject</th>
                        <th width="12%">From Office</th>
                        <th width="12%">To Office</th>
                        <th width="12%">Routed By</th>
                        <th width="10%">Status</th>
                        <th width="7%">Days</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($routes ?? [] as $route)
                        <tr>
                            <td>
                                {{ $route->routed_at ? $route->routed_at->format('M d, Y h:i A') : 'N/A' }}
                            </td>

                            <td>
                                <span class="tracking-no">
                                    {{ $route->document->tracking_number ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                {{ $route->document->subject ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $route->fromOffice->office_code ?? $route->fromOffice->office_name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $route->toOffice->office_code ?? $route->toOffice->office_name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $route->routedBy->name ?? 'N/A' }}
                            </td>

                            <td>
                                @php
                                    $status = strtolower($route->status ?? 'pending');

                                    $badge = match ($status) {
                                        'received' => 'success',
                                        'completed' => 'primary',
                                        'returned' => 'danger',
                                        'routed' => 'info',
                                        default => 'warning',
                                    };
                                @endphp

                                <span class="badge bg-{{ $badge }}">
                                    {{ strtoupper(str_replace('_', ' ', $route->status ?? 'PENDING')) }}
                                </span>
                            </td>

                            <td class="text-center fw-bold">
                                @if($route->routed_at)
                                    {{ $route->routed_at->diffInDays(now()) }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No tracking records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if(isset($routes) && method_exists($routes, 'links'))
                <div class="mt-3 no-print">
                    {{ $routes->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection