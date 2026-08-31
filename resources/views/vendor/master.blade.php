<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    @yield('styles')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/components.css') }}">
    <style>
        /* ===== VENDOR MASTER GLOBAL ===== */
        body { background: #f1f5f9 !important; }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .main-sidebar {
                position: fixed !important;
                left: -280px !important;
                top: 0 !important;
                height: 100vh !important;
                z-index: 9999 !important;
                transition: left 0.3s ease !important;
                box-shadow: 4px 0 25px rgba(0,0,0,0.3) !important;
            }
            .main-sidebar.open { left: 0 !important; }
            .main-content { margin-left: 0 !important; }
            .mobile-sidebar-overlay {
                display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9998;
            }
            .mobile-sidebar-overlay.active { display: block; }
            .vendor-mobile-menu-btn { display: inline-block !important; }
            .vendor-sidebar-close { display: flex !important; align-items: center; justify-content: center; }
        }
        .vendor-mobile-menu-btn { display: none; }
        .navbar-bg { background: #fff !important; box-shadow: 0 1px 0 #e2e8f0; }
        .main-navbar {
            background: #fff !important;
            box-shadow: 0 2px 12px rgba(15,23,42,.07) !important;
            border-bottom: 1px solid #e2e8f0;
        }
        .main-sidebar { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important; }
        .sidebar-brand { border-bottom: 1px solid rgba(255,255,255,.07) !important; }
        .sidebar-brand a { color: #f59e0b !important; font-weight: 800 !important; font-size: 1.1rem !important; }
        .sidebar-menu > li > a {
            color: rgba(255,255,255,.7) !important;
            border-radius: 10px;
            margin: 2px 10px;
            padding: 10px 16px !important;
            transition: all .2s;
        }
        .sidebar-menu > li > a:hover,
        .sidebar-menu > li > a.active {
            background: rgba(99,102,241,.2) !important;
            color: #fff !important;
            border-left: 3px solid #6366f1;
        }
        .sidebar-menu > li > a i { color: #6366f1 !important; width: 22px; }
        .menu-header {
            color: rgba(255,255,255,.3) !important;
            font-size: .65rem !important;
            letter-spacing: 2px;
            padding: 14px 24px 4px !important;
        }
        .main-footer {
            background: #fff !important;
            border-top: 1px solid #e2e8f0 !important;
            color: #64748b !important;
            font-size: .82rem;
        }
        .main-sidebar { z-index: 880 !important; }
        .main-content { background: #f1f5f9 !important; padding-left: 280px !important; padding-top: 80px !important; position: relative !important; z-index: 890 !important; }
        @media (max-width: 1024px) {
            .main-content { padding-left: 30px !important; }
        }
        /* Card base */
        .card { border-radius: 14px !important; border: none !important; box-shadow: 0 2px 16px rgba(0,0,0,.06) !important; }
        .vendor-sidebar-close { display: none; }
    </style>

    <script>
        function openMobileSidebar() {
            document.querySelector('.main-sidebar').classList.add('open');
            document.querySelector('.mobile-sidebar-overlay').classList.add('active');
        }
        function closeMobileSidebar() {
            document.querySelector('.main-sidebar').classList.remove('open');
            document.querySelector('.mobile-sidebar-overlay').classList.remove('active');
        }
    </script>
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div class="mobile-sidebar-overlay" onclick="closeMobileSidebar()"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('vendor.nav')
            @include('vendor.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            @include('vendor.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('vendor/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/popper.js') }}"></script>
    <script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
    <script src="{{ asset('vendor/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    @yield('scripts')

    <!-- Template JS File -->
    <script src="{{ asset('vendor/js/scripts.js') }}"></script>
    <script src="{{ asset('vendor/js/custom.js') }}"></script>
</body>

</html>
