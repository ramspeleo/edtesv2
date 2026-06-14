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

    .gov-section-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.25rem;
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
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">
        <div>
            <h3 class="gov-page-title mb-1">
                Route Document
            </h3>

            <div class="gov-divider"></div>

            <small class="gov-subtitle d-block mt-2">
                Forward the document to the appropriate office for official action, review, approval, or filing.
            </small>
        </div>

        <a href="{{ route('documents.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Document Registry
        </a>
    </div>

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
                <i class="bi bi-send-fill me-2"></i>
                Document Routing Form
            </span>

            <small class="fw-normal">
                Official Routing Transaction
            </small>
        </div>

        <div class="card-body bg-white">

            <div class="alert alert-light border mb-4">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                Verify the document details before routing. Fields marked with
                <span class="text-danger fw-bold">*</span>
                are required.
            </div>

            <div class="row">

                <div class="col-lg-5 mb-4 mb-lg-0">

                    <div class="card gov-section-card h-100">
                        <div class="gov-section-header">
                            <h5 class="mb-1">
                                <i class="bi bi-file-earmark-text-fill me-1"></i>
                                Document Summary
                            </h5>
                            <small class="text-muted">
                                Reference information of the document to be routed.
                            </small>
                        </div>

                        <div class="card-body">

                            <div class="gov-info-label">Document No.</div>
                            <div class="gov-info-value">
                                {{ $document->document_number }}
                            </div>

                            <div class="gov-info-label">Tracking No.</div>
                            <div class="gov-info-value">
                                {{ $document->tracking_number }}
                            </div>

                            <div class="gov-info-label">Document Subject</div>
                            <div class="gov-info-value">
                                {{ $document->subject }}
                            </div>

                            <div class="gov-info-label">Current Custodian Office</div>
                            <div class="gov-info-value mb-0">
                                {{ $document->currentOffice->office_name ?? 'N/A' }}
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-lg-7">

                    <form method="POST"
                          action="{{ route('documents.route.store', $document) }}">
                        @csrf

                        <div class="card gov-section-card">
                            <div class="gov-section-header">
                                <h5 class="mb-1">
                                    <i class="bi bi-diagram-3-fill me-1"></i>
                                    Routing Details
                                </h5>
                                <small class="text-muted">
                                    Select destination office and specify the required action.
                                </small>
                            </div>

                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Route To Office <span class="text-danger">*</span>
                                    </label>

                                    <select name="to_office_id"
                                            class="form-select @error('to_office_id') is-invalid @enderror"
                                            required>
                                        <option value="">
                                            Select Destination Office
                                        </option>

                                        @foreach($offices as $office)
                                            <option value="{{ $office->id }}"
                                                {{ old('to_office_id') == $office->id ? 'selected' : '' }}>
                                                {{ $office->office_code }} - {{ $office->office_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('to_office_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Action Required <span class="text-danger">*</span>
                                    </label>

                                    <select name="action_required"
                                            class="form-select @error('action_required') is-invalid @enderror"
                                            required>
                                        @foreach([
                                            'For Review',
                                            'For Endorsement',
                                            'For Approval',
                                            'For Signature',
                                            'For Compliance',
                                            'For Information',
                                            'For Filing'
                                        ] as $action)
                                            <option value="{{ $action }}"
                                                {{ old('action_required') == $action ? 'selected' : '' }}>
                                                {{ $action }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('action_required')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        Routing Remarks
                                    </label>

                                    <textarea name="remarks"
                                              rows="4"
                                              class="form-control"
                                              placeholder="Enter remarks or instructions for the receiving office">{{ old('remarks') }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('documents.index') }}"
                                       class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Cancel
                                    </a>

                                    <button type="submit"
                                            class="btn btn-gov-primary">
                                        <i class="bi bi-send-fill me-1"></i>
                                        Route Document
                                    </button>
                                </div>

                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection