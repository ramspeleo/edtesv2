<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EDTES') }}</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800;900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.bunny.net">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
</head>

<body class="app-body">

    {{-- Navbar --}}
    @include('layouts.nav.navbar')

    {{-- Mobile Sidebar --}}
    <div class="offcanvas offcanvas-start app-offcanvas"
         tabindex="-1"
         id="mobileSidebar">

        <div class="offcanvas-header">
            <div>
                <h5 class="offcanvas-title mb-0 fw-bold">
                    EDTES
                </h5>
                <small class="text-muted">
                    Document Tracking System
                </small>
            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas">
            </button>
        </div>

        <div class="offcanvas-body p-0">
            @include('layouts.nav.sidebar-menu')
        </div>

    </div>

    {{-- Main Content Area --}}
    <div class="app-shell">

        {{-- Desktop Sidebar --}}
        <aside class="app-sidebar d-none d-md-block">
            @include('layouts.nav.sidebar')
        </aside>

        {{-- Page Content --}}
        <main class="app-main">
            @yield('content')
        </main>

    </div>

    {{-- Footer --}}
   <footer class="app-footer">
        <div class="footer-content">
            <span>
                © 2026 EDTES
                <span class="text-primary">| Electronic Document Tracking and Exchange System</span>
            </span>

            <span class="footer-divider">•</span>

            <span>
                Designed &amp; Developed by <strong>RAMS</strong>
            </span>
            <span class="footer-divider">•</span>
            <span class="text-muted">Research Information Division</span>
        </div>
    </footer>
      

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- OverlayScrollbars -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
            crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElList = document.querySelectorAll('.toast');

            toastElList.forEach(function (toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });

                toast.show();
            });
        });
    </script>

    @stack('scripts')

</body>
</html>