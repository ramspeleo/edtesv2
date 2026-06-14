@extends('layouts.app')

@section('content')



<div class="gov-dashboard">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="gov-page-title mb-1">Dashboard</h3>
            <div class="text-muted small">Document monitoring and routing overview</div>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-3">
            <div class="gov-stat-card">
                <div class="gov-stat-header bg-primary"></div>
                <div class="gov-stat-body">
                    <div class="gov-stat-label">Registered</div>
                    <h2 class="gov-stat-number">{{ $registered }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="gov-stat-card">
                <div class="gov-stat-header bg-warning"></div>
                <div class="gov-stat-body">
                    <div class="gov-stat-label">In Route</div>
                    <h2 class="gov-stat-number">{{ $inRoute }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="gov-stat-card">
                <div class="gov-stat-header bg-success"></div>
                <div class="gov-stat-body">
                    <div class="gov-stat-label">Received</div>
                    <h2 class="gov-stat-number">{{ $received }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="gov-stat-card">
                <div class="gov-stat-header bg-dark"></div>
                <div class="gov-stat-body">
                    <div class="gov-stat-label">Completed</div>
                    <h2 class="gov-stat-number">{{ $completed }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mt-1">

        <div class="col-md-6">
            <div class="gov-stat-card">
                <div class="gov-stat-header" style="background: var(--gov-navy);"></div>
                <div class="gov-stat-body">
                    <div class="gov-stat-label">My Inbox</div>
                    <h2 class="gov-stat-number">{{ $myInbox }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="gov-stat-card">
                <div class="gov-stat-header" style="background: var(--gov-gold);"></div>
                <div class="gov-stat-body">
                    <div class="gov-stat-label">My Outbox</div>
                    <h2 class="gov-stat-number">{{ $myOutbox }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="gov-panel mt-4">

        <div class="gov-panel-header">
            Recent Documents
        </div>

        <div class="card-body bg-white">

            <div class="table-responsive">
                <table class="table table-hover align-middle gov-table mb-0">
                    <thead>
                        <tr>
                            <th>Document No.</th>
                            <th>Subject</th>
                            <th>Office</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recentDocuments as $document)
                            <tr>
                                <td class="fw-semibold text-primary">
                                    {{ $document->document_number }}
                                </td>
                                <td>{{ $document->subject }}</td>
                                <td>
                                    <span class="badge text-bg-light border">
                                        {{ $document->currentOffice->office_code ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $status = strtolower($document->status);
                                        $badgeClass = match($status) {
                                            'registered' => 'text-bg-primary',
                                            'in route' => 'text-bg-warning',
                                            'received' => 'text-bg-success',
                                            'completed' => 'text-bg-dark',
                                            default => 'text-bg-secondary',
                                        };
                                    @endphp

                                    <span class="status-badge {{ $badgeClass }}">
                                        {{ strtoupper($document->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No recent documents found.
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