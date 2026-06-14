@extends('layouts.app')

@section('content')
<style>
    .gov-page-title {
        color: #003366;
        font-weight: 700;
    }

    .gov-divider {
        width: 70px;
        height: 4px;
        background: #f7c948;
        border-radius: 10px;
        margin-top: 8px;
    }

    .gov-subtitle {
        color: #6c757d;
        font-size: .9rem;
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
</style>

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gov-page-title mb-1">
            Create Office
        </h3>

        <div class="gov-divider"></div>

        <small class="gov-subtitle d-block mt-2">
            Register a new office and define its organizational hierarchy,
            classification, and status within the agency structure.
        </small>
    </div>

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('offices.index') }}">
                    Offices
                </a>
            </li>
            <li class="breadcrumb-item active">
                Create Office
            </li>
        </ol>
    </nav>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card gov-card shadow-sm">

        <div class="gov-card-header">
            <i class="fas fa-building me-2"></i>
            Office Information
        </div>

        <div class="card-body">

            <div class="alert alert-light border">
                <i class="fas fa-info-circle text-primary me-2"></i>
                Fields marked with
                <span class="text-danger fw-bold">*</span>
                are required.
            </div>

            <form action="{{ route('offices.store') }}"
                  method="POST">
                @csrf

                @include('offices.form')

                <hr>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('offices.index') }}"
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to List
                    </a>

                    <button type="submit"
                            class="btn btn-gov-primary">
                        <i class="fas fa-save me-1"></i>
                        Save Office
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection