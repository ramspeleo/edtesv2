<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EDTES | Electronic Document Tracking and Evaluation System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --gov-primary:#003366;
            --gov-secondary:#0d6efd;
            --gov-light:#f8f9fa;
        }

        .hero-section{
            background: linear-gradient(
                135deg,
                #ffffff 0%,
                #f5f8fc 100%
            );
        }

        .feature-card{
            border:none;
            border-radius:16px;
            transition:.3s;
            box-shadow:0 4px 20px rgba(0,0,0,.05);
        }

        .feature-card:hover{
            transform:translateY(-5px);
        }

        .system-logo{
            max-height:90px;
        }

        .agency-logo{
            max-height:65px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- HEADER --}}
 <nav class="navbar navbar-expand-lg navbar-dark shadow-sm"
     style="background: var(--gov-primary);">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-3" href="#">

            <img src="{{ asset('assets/images/ncmblogo.png') }}"
                 alt="NCMB Logo"
                 style="height:60px; width:auto;">

            <div>
                <div class="fw-bold fs-5">
                    National Conciliation and Mediation Board
                </div>

                <small class="text-light opacity-75">
                    Department of Labor and Employment
                </small>
            </div>

        </a>

        {{-- <div>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="btn btn-light">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="btn btn-light">
                    Sign In
                </a>
            @endauth
        </div> --}}

    </div>
</nav>

    {{-- HERO --}}
    <section class="hero-section py-5">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-7">
{{-- 
                    <span class="badge bg-primary mb-3 px-3 py-2">
                        National Conciliation and Mediation Board
                    </span> --}}

                    <h1 class="display-5 fw-bold text-dark">
                        Electronic Document Tracking and Evaluation System
                    </h1>

                    <p class="lead text-secondary mt-3">
                        A centralized platform for registering, routing,
                        tracking, receiving, and monitoring official documents
                        across NCMB offices.
                    </p>

                    <div class="mt-4">

                        @auth
                            <a href="{{ route('documents.index') }}"
                               class="btn btn-primary btn-lg px-4">
                                Open System
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="btn btn-primary btn-lg px-4">
                                Sign In
                            </a>
                        @endauth

                    </div>

                </div>

                <div class="col-lg-5 text-center">
                    <img src="{{ asset('assets/images/edtesv2.png') }}"
                         class="img-fluid system-logo"
                         alt="EDTES Logo" style="max-height: 320px; width:auto;">
                </div>

            </div>

        </div>
    </section>

    {{-- FEATURES --}}
    <section class="py-5 bg-white">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="fw-bold">Core Functions</h2>
                <p class="text-muted">
                    Designed to enhance document accountability,
                    transparency, and processing efficiency.
                </p>
            </div>

            <div class="row g-4">

                <!-- Register -->
                <div class="col-md-3">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-file-earmark-plus fs-1 text-primary"></i>
                            </div>
                            <h5 class="fw-bold">Register</h5>
                            <p class="text-muted mb-0">
                                Create, record, and manage official documents securely.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Route -->
                <div class="col-md-3">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-arrow-left-right fs-1 text-success"></i>
                            </div>
                            <h5 class="fw-bold">Route</h5>
                            <p class="text-muted mb-0">
                                Forward documents efficiently between offices and units.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Track -->
                <div class="col-md-3">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-geo-alt fs-1 text-info"></i>
                            </div>
                            <h5 class="fw-bold">Track</h5>
                            <p class="text-muted mb-0">
                                Monitor document status and movement in real time.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Evaluate -->
                <div class="col-md-3">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3">
                                <i class="bi bi-clipboard-check fs-1 text-warning"></i>
                            </div>
                            <h5 class="fw-bold">Evaluate</h5>
                            <p class="text-muted mb-0">
                                Review actions, monitor compliance, and assess progress.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="mt-auto py-4 text-white"
            style="background: var(--gov-primary);">

        <div class="container text-center">

            <div class="fw-semibold">
                National Conciliation and Mediation Board
            </div>

            <small class="d-block">
                Department of Labor and Employment
            </small>

            <small class="d-block mt-2 opacity-75">
                © {{ date('Y') }}
                Electronic Document Tracking and Evaluation System (EDTES)
            </small>

        </div>

    </footer>

</body>
</html>