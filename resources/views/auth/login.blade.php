<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | {{ config('app.name', 'EDTES') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gov-login-page {
            min-height: 100dvh;

            background:
                linear-gradient(
                    135deg,
                    rgba(11, 46, 74, 0.88) 0%,
                    rgba(22, 79, 122, 0.80) 50%,
                    rgba(11, 46, 74, 0.92) 100%
                ),
                url('{{ asset("assets/images/government-bg.png") }}');

            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="gov-login-page">

        <div class="gov-login-card">

            <div class="gov-login-left">
                <div class="gov-login-brand">

                    <div class="gov-login-logo-wrapper">
                        <img src="{{ asset('assets/images/edtesv2.png') }}"
                            alt="EDTES Logo"
                            class="gov-login-logo">
                    </div>

                    <h1 class="gov-system-name">
                        EDTES
                    </h1>

                    {{-- <p class="gov-system-description">
                        Electronic Document Tracking System
                    </p> --}}

                    <div class="gov-system-badge">
                        Electronic Document Tracking and Evaluation System
                    </div>

                </div>

                <div class="gov-login-info">

                    <div class="gov-agency-title">
                        National Conciliation and Mediation Board
                    </div>

                    <div class="gov-agency-subtitle">
                        Department of Labor and Employment
                    </div>

                    <div class="gov-agency-divider"></div>

                    <p class="gov-agency-description">
                        Authorized access to the Electronic Document Tracking and Exchange System
                        for document registration, routing, monitoring, and records management.
                    </p>

                </div>
            </div>

            <div class="gov-login-right">

                <div class="gov-login-header">
                    <h5>Sign in to your account</h5>
                    <p>Use your authorized credentials to continue.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control gov-form-control @error('email') is-invalid @enderror"
                               required
                               autofocus
                               autocomplete="username">

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password
                        </label>

                        <input id="password"
                               type="password"
                               name="password"
                               class="form-control gov-form-control @error('password') is-invalid @enderror"
                               required
                               autocomplete="current-password">

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label for="remember" class="d-flex align-items-center gap-2 small text-muted">
                            <input id="remember"
                                   type="checkbox"
                                   class="form-check-input mt-0"
                                   name="remember">

                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="gov-login-link">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn gov-login-btn w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Log in
                    </button>
                </form>

                <div class="gov-login-footer">
                    Authorized personnel only. All activities may be monitored.
                </div>

            </div>

        </div>

    </div>

</body>
</html>