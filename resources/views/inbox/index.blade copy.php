@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">My Inbox</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Document No.</th>
                            <th>Tracking No.</th>
                            <th>Subject</th>
                            <th>From Office</th>
                            <th>Action Required</th>
                            <th>Date Routed</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($routes as $route)
                            <tr>
                                <td>{{ $route->document->document_number ?? '' }}</td>
                                <td>{{ $route->document->tracking_number ?? '' }}</td>
                                <td>{{ $route->document->subject ?? '' }}</td>
                                <td>{{ $route->fromOffice->office_code ?? '' }}</td>
                                <td>{{ $route->action_required }}</td>
                                <td>
                                    {{ $route->routed_at ? \Carbon\Carbon::parse($route->routed_at)->format('M d, Y h:i A') : '' }}
                                </td>
                                <td>
                                    <a href="{{ route('documents.show', $route->document) }}"
                                       class="btn btn-sm btn-info mb-1">
                                        View
                                    </a>

                                    <form method="POST"
                                          action="{{ route('routes.receive', $route) }}"
                                          class="d-inline">
                                        @csrf

                                        <button type="submit"
                                                class="btn btn-sm btn-success mb-1">
                                            Receive
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No documents in your inbox.
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