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

    {{-- ===== VENDOR SIDEBAR STYLES ===== --}}
    <style>
        /* Reset body */
        html { overflow-x: hidden; }
        body { background: #f1f5f9 !important; overflow-x: hidden; }

        /* ---- Sidebar Shell ---- */
        .vendor-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            z-index: 9999;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            display: flex;
            flex-direction: column;
        }

        /* ---- Sidebar Inner ---- */
        .vendor-sidebar-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        /* ---- Brand ---- */
        .vendor-sidebar-brand {
            flex-shrink: 0;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255,255,255,.07);
            padding: 0 20px;
        }
        .vendor-sidebar-brand a {
            color: #f59e0b !important;
            font-weight: 800;
            font-size: 1.05rem;
            text-decoration: none;
            letter-spacing: .5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ---- Scrollable Menu ---- */
        .vendor-sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0;
            /* Native scroll, no nicescroll needed */
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.15) transparent;
        }
        .vendor-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .vendor-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .vendor-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.15);
            border-radius: 99px;
        }

        /* ---- Menu ---- */
        .vendor-sidebar-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .vendor-menu-header {
            color: rgba(255,255,255,.3) !important;
            font-size: .62rem !important;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
            padding: 14px 22px 4px;
            display: block;
        }

        .vendor-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            margin: 2px 10px;
            border-radius: 10px;
            color: rgba(255,255,255,.65) !important;
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: background .2s, color .2s, padding-left .2s;
            white-space: nowrap;
        }
        .vendor-nav-link:hover,
        .vendor-nav-link.active {
            background: rgba(99,102,241,.18) !important;
            color: #fff !important;
            padding-left: 26px;
        }
        .vendor-nav-link i {
            color: #6366f1;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        /* ---- Footer ---- */
        .vendor-sidebar-foot {
            flex-shrink: 0;
            padding: 12px 20px;
            border-top: 1px solid rgba(255,255,255,.07);
            text-align: center;
        }
        .vendor-sidebar-foot small {
            color: rgba(255,255,255,.25);
            font-size: .68rem;
        }

        /* ---- Mobile close button ---- */
        .vendor-sidebar-close {
            display: none;
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255,255,255,.1);
            border: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            z-index: 10001;
        }

        /* ---- Overlay ---- */
        .mobile-sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 9998;
        }
        .mobile-sidebar-overlay.active { display: block; }

        /* ---- Mobile menu button ---- */
        .vendor-mobile-menu-btn { display: none; }

        /* ---- Main Content ---- */
        .main-content {
            margin-left: 260px;
            padding-top: 70px;
            padding-left: 28px;
            padding-right: 28px;
            min-height: 100vh;
            background: #f1f5f9;
            position: relative;
            z-index: 1;
            max-width: calc(100vw - 260px);
            overflow-x: hidden;
        }

        /* ---- Navbar ---- */
        .navbar-bg { display: none !important; }
        .main-navbar {
            background: #fff !important;
            box-shadow: 0 2px 12px rgba(15,23,42,.07) !important;
            border-bottom: 1px solid #e2e8f0;
        }
        .navbar {
            left: 260px !important;
            right: 0 !important;
            z-index: 9990 !important;
        }
        .navbar .nav-link,
        .navbar .nav-link div,
        .navbar .nav-link-user,
        .navbar .nav-link-user div {
            color: #1e293b !important;
        }
        .navbar .nav-link:hover,
        .navbar .nav-link:hover div {
            color: #6366f1 !important;
        }

        /* ---- Footer ---- */
        .main-footer {
            margin-left: 260px;
            background: #fff !important;
            border-top: 1px solid #e2e8f0 !important;
            color: #64748b !important;
            font-size: .82rem;
            padding-left: 28px;
        }

        /* ---- Card base ---- */
        .card {
            border-radius: 14px !important;
            border: none !important;
            box-shadow: 0 2px 16px rgba(0,0,0,.06) !important;
        }

        /* ---- Responsive adjustments ---- */
        @media (max-width: 768px) {
            .main-content { padding-top: 60px !important; padding-left: 14px !important; padding-right: 14px !important; }
            .vd-stat-card { padding: 18px 16px 14px !important; min-height: 110px !important; }
            .vd-stat-card .stat-value { font-size: 1.4rem !important; }
            .vd-stat-card .stat-icon { width: 40px !important; height: 40px !important; font-size: 1rem !important; }
            .vd-chart-card { padding: 16px !important; }
            .vd-chart-card .vd-card-title { font-size: .9rem !important; }
            .vd-product-item img { width: 40px !important; height: 40px !important; }
            .vd-product-item .vd-prod-name { font-size: .82rem !important; }
            .main-navbar { min-height: 56px !important; }
            .navbar { left: 0 !important; }
        }

        /* ---- RESPONSIVE ---- */
        @media (max-width: 768px) {
            /* Slide-in sidebar on mobile */
            .vendor-sidebar {
                left: -270px !important;
                transition: left .3s ease;
                box-shadow: none;
            }
            .vendor-sidebar.mobile-open {
                left: 0 !important;
                box-shadow: 4px 0 25px rgba(0,0,0,.4);
            }
            .vendor-sidebar-close { display: flex; }
            .main-content {
                margin-left: 0 !important;
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            .navbar { left: 0 !important; }
            .main-footer { margin-left: 0 !important; padding-left: 16px; }
            .vendor-mobile-menu-btn { display: inline-block !important; }
            /* Prevent overflow on very small screens */
            html, body { overflow-x: hidden !important; }
            .main-content { max-width: 100vw !important; }
        }
    </style>

    <script>
        function openMobileSidebar() {
            document.querySelector('.vendor-sidebar').classList.add('mobile-open');
            document.querySelector('.mobile-sidebar-overlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeMobileSidebar() {
            document.querySelector('.vendor-sidebar').classList.remove('mobile-open');
            document.querySelector('.mobile-sidebar-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div class="mobile-sidebar-overlay" onclick="closeMobileSidebar()"></div>

    {{-- Sidebar --}}
    @include('vendor.sidebar')

    {{-- Navbar --}}
    @include('vendor.nav')

    {{-- Main Content --}}
    <div class="main-content">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('vendor.footer')
</body>
<script src="{{ asset('vendor/modules/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/modules/popper.js') }}"></script>
<script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
<script src="{{ asset('vendor/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/modules/moment.min.js') }}"></script>
<script src="{{ asset('vendor/js/stisla.js') }}"></script>

<!-- JS Libraies -->
@yield('scripts')

<!-- Template JS File -->
<script src="{{ asset('vendor/js/scripts.js') }}"></script>
<script src="{{ asset('vendor/js/custom.js') }}"></script>

</body>

</html>
