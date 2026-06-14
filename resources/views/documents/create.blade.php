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

    .upload-box {
        border: 2px dashed #b6c7d6;
        border-radius: 10px;
        background: #f8fafc;
        padding: 1.5rem;
        text-align: center;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row gap-3 mb-4">
        <div>
            <h3 class="gov-page-title mb-1">Register Official Document</h3>
            <div class="gov-divider"></div>
            <small class="gov-subtitle d-block mt-2">
                Register incoming or outgoing documents and initiate routing within the Electronic Document Tracking and Exchange System.
            </small>
        </div>

        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Document Registry
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0">
            <strong>
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Please correct the following errors:
            </strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('documents.store') }}"
          enctype="multipart/form-data">
        @csrf

        <div class="card gov-card shadow-sm">

            <div class="gov-card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-file-earmark-text-fill me-2"></i>
                    Document Registration Form
                </span>

                <small class="fw-normal">
                    EDTES Document Registry
                </small>
            </div>

            <div class="card-body bg-white">

                <div class="alert alert-light border mb-4">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i>
                    Fields marked with
                    <span class="text-danger fw-bold">*</span>
                    are required. Registered documents will be assigned a system-generated tracking reference.
                </div>

                <div class="row">

                    <div class="col-lg-8">

                        <div class="card gov-section-card mb-4">
                            <div class="gov-section-header">
                                <h5 class="mb-1">
                                    <i class="bi bi-journal-text me-1"></i>
                                    Document Details
                                </h5>
                                <small class="text-muted">
                                    Provide the basic information and classification of the document.
                                </small>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Reference Number
                                        </label>

                                        <input type="text"
                                               name="reference_number"
                                               class="form-control"
                                               value="{{ old('reference_number') }}"
                                               placeholder="Enter reference number, if available">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Document Date
                                        </label>

                                        <input type="date"
                                               name="document_date"
                                               class="form-control"
                                               value="{{ old('document_date') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Document Type <span class="text-danger">*</span>
                                    </label>

                                    <select name="document_type_id"
                                            class="form-select"
                                            required>
                                        <option value="">Select Document Type</option>

                                        @foreach($documentTypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Document Subject <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="subject"
                                           class="form-control"
                                           value="{{ old('subject') }}"
                                           placeholder="Enter document subject"
                                           required>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">
                                        Remarks / Description
                                    </label>

                                    <textarea name="description"
                                              rows="5"
                                              class="form-control"
                                              placeholder="Enter brief description or remarks">{{ old('description') }}</textarea>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="card gov-section-card mb-4">
                            <div class="gov-section-header">
                                <h5 class="mb-1">
                                    <i class="bi bi-diagram-3-fill me-1"></i>
                                    Initial Routing Information
                                </h5>
                                <small class="text-muted">
                                    Define the originating office, priority, and security classification.
                                </small>
                            </div>

                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label">
                                        Originating Office <span class="text-danger">*</span>
                                    </label>

                                    <select name="origin_office_id"
                                            class="form-select"
                                            required>
                                        <option value="">Select Originating Office</option>

                                        @foreach($offices as $office)
                                            <option value="{{ $office->id }}"
                                                {{ old('origin_office_id') == $office->id ? 'selected' : '' }}>
                                                {{ $office->office_code }} - {{ $office->office_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Processing Priority
                                    </label>

                                    <select name="priority" class="form-select">
                                        <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>
                                            Normal
                                        </option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                            Urgent
                                        </option>
                                        <option value="very_urgent" {{ old('priority') == 'very_urgent' ? 'selected' : '' }}>
                                            Very Urgent
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">
                                        Security Classification
                                    </label>

                                    <select name="confidentiality" class="form-select">
                                        <option value="internal" {{ old('confidentiality', 'internal') == 'internal' ? 'selected' : '' }}>
                                            Internal Use
                                        </option>
                                        <option value="confidential" {{ old('confidentiality') == 'confidential' ? 'selected' : '' }}>
                                            Confidential
                                        </option>
                                        <option value="restricted" {{ old('confidentiality') == 'restricted' ? 'selected' : '' }}>
                                            Restricted Access
                                        </option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="card gov-section-card mb-4">
                            <div class="gov-section-header">
                                <h5 class="mb-1">
                                    <i class="bi bi-paperclip me-1"></i>
                                    Primary Attachment
                                </h5>
                                <small class="text-muted">
                                    Upload the main document file, if available.
                                </small>
                            </div>

                            <div class="card-body">
                                <div class="upload-box">
                                    <i class="bi bi-cloud-arrow-up-fill fs-1 text-primary"></i>

                                    <h6 class="mt-2 mb-1">
                                        Upload Main Document
                                    </h6>

                                    <p class="text-muted small mb-3">
                                        Supported file types: PDF, JPG, PNG, DOC, DOCX
                                    </p>

                                    <input type="file"
                                           name="main_document"
                                           id="main_document"
                                           class="form-control"
                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </div>
                            </div>
                        </div>

                        <div id="filePreview"
                             class="card gov-section-card mb-4 d-none">
                            <div class="gov-section-header">
                                <h5 class="mb-1">
                                    <i class="bi bi-eye-fill me-1"></i>
                                    Attached Document Preview
                                </h5>
                                <small class="text-muted">
                                    Preview of the selected attachment.
                                </small>
                            </div>

                            <div class="card-body">
                                <div id="previewContainer"></div>
                            </div>
                        </div>

                        <div class="card gov-section-card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit"
                                            class="btn btn-gov-primary btn-lg">
                                        <i class="bi bi-save-fill me-1"></i>
                                        Register Document
                                    </button>

                                    <a href="{{ route('documents.index') }}"
                                       class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Cancel Registration
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('main_document');
    const previewWrapper = document.getElementById('filePreview');
    const previewContainer = document.getElementById('previewContainer');

    if (!fileInput) {
        return;
    }

    fileInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        previewContainer.innerHTML = '';

        if (!file) {
            previewWrapper.classList.add('d-none');
            return;
        }

        previewWrapper.classList.remove('d-none');

        const fileType = file.type;
        const fileURL = URL.createObjectURL(file);
        const fileSize = (file.size / 1024 / 1024).toFixed(2);

        if (fileType === 'application/pdf') {
            previewContainer.innerHTML = `
                <div class="mb-2 text-muted small">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i>
                    ${file.name} (${fileSize} MB)
                </div>

                <iframe src="${fileURL}"
                        width="100%"
                        height="500"
                        class="border rounded">
                </iframe>
            `;
        } else if (fileType.startsWith('image/')) {
            previewContainer.innerHTML = `
                <div class="mb-2 text-muted small">
                    <i class="bi bi-file-earmark-image-fill me-1"></i>
                    ${file.name} (${fileSize} MB)
                </div>

                <img src="${fileURL}"
                     class="img-fluid rounded border"
                     style="max-height: 500px;">
            `;
        } else {
            previewContainer.innerHTML = `
                <div class="alert alert-info mb-0">
                    <i class="bi bi-file-earmark-text-fill me-1"></i>
                    <strong>Selected File:</strong><br>
                    ${file.name} (${fileSize} MB)
                </div>
            `;
        }
    });
});
</script>
@endpush