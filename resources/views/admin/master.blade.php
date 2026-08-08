<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | UBold - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

    <style>
        /* ===== ADMIN DESIGN SYSTEM — bold / vibrant ===== */
        :root {
            --adm-primary: #4f46e5;
            --adm-primary-dark: #3730a3;
            --adm-accent: #f43f5e;
            --adm-accent-dark: #e11d48;
            --adm-ink: #1e1b4b;
            --adm-muted: #64748b;
            --adm-bg: #f4f5fb;
            --adm-radius: 14px;
        }

        body { background: var(--adm-bg) !important; }

        /* --- Topbar --- */
        .navbar-custom {
            background: #ffffff !important;
            box-shadow: 0 6px 24px rgba(79, 70, 229, 0.08) !important;
            border-bottom: 1px solid #ececf7;
        }

        .navbar-custom .logo-box {
            background: linear-gradient(135deg, var(--adm-primary) 0%, #7c3aed 100%) !important;
        }

        .navbar-custom .topnav-menu .nav-link,
        .navbar-custom .button-menu-mobile {
            color: var(--adm-ink) !important;
        }

        .navbar-custom .nav-user .pro-user-name {
            color: var(--adm-ink) !important;
            font-weight: 600;
        }

        .navbar-custom .nav-link:hover {
            color: var(--adm-primary) !important;
        }

        .profile-dropdown {
            border-radius: 14px !important;
            border: none !important;
            box-shadow: 0 20px 45px rgba(30, 27, 75, 0.16) !important;
            overflow: hidden;
        }

        .profile-dropdown .notify-item:hover {
            background: rgba(79, 70, 229, 0.08) !important;
            color: var(--adm-primary) !important;
        }

        /* --- Sidebar --- */
        .left-side-menu {
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 55%, #4338ca 100%) !important;
            border: none !important;
        }

        #sidebar-menu .menu-title {
            color: rgba(255, 255, 255, 0.35) !important;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        #sidebar-menu ul li a {
            color: rgba(226, 232, 240, 0.85) !important;
            font-weight: 500;
            border-radius: 10px;
            margin: 2px 10px;
            transition: all 0.25s ease;
        }

        #sidebar-menu ul li a:hover,
        #sidebar-menu ul li a:focus {
            color: #ffffff !important;
            background: rgba(244, 63, 94, 0.16) !important;
        }

        #sidebar-menu ul li a i {
            color: rgba(226, 232, 240, 0.65) !important;
        }

        #sidebar-menu ul li a:hover i {
            color: var(--adm-accent) !important;
        }

        #sidebar-menu ul li .nav-second-level li a {
            color: rgba(226, 232, 240, 0.65) !important;
        }

        #sidebar-menu ul li .nav-second-level li a:hover {
            color: #fff !important;
        }

        .logo-box .logo-light img { filter: brightness(0) invert(1); }

        /* --- Page title --- */
        .page-title-box .page-title {
            font-weight: 800;
            color: var(--adm-ink);
            letter-spacing: -0.01em;
        }

        /* --- Cards --- */
        .card {
            border: none !important;
            border-radius: var(--adm-radius) !important;
            box-shadow: 0 4px 20px rgba(30, 27, 75, 0.07) !important;
        }

        .card .card-body { padding: 1.5rem; }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 16px 20px !important;
            font-weight: 700;
            font-size: .95rem;
            color: var(--adm-ink);
        }

        .header-title {
            font-weight: 800 !important;
            color: var(--adm-ink) !important;
            font-size: 1rem;
        }

        /* --- Status badges (shared across orders / magasins / etc.) --- */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .01em;
        }

        .sb-pending, .sb-inactive { background: #fef9c3; color: #854d0e; }
        .sb-delivered, .sb-active, .sb-confirmed { background: #dcfce7; color: #166534; }
        .sb-processing, .sb-shipped { background: #dbeafe; color: #1e40af; }
        .sb-cancelled, .sb-blocked { background: #fee2e2; color: #991b1b; }

        /* --- Buttons --- */
        .btn {
            border-radius: 10px !important;
            font-weight: 600 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--adm-primary) 0%, #7c3aed 100%) !important;
            border: none !important;
            box-shadow: 0 10px 24px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover { box-shadow: 0 14px 30px rgba(79, 70, 229, 0.35); transform: translateY(-1px); }

        .btn-danger {
            background: linear-gradient(135deg, var(--adm-accent) 0%, var(--adm-accent-dark) 100%) !important;
            border: none !important;
            box-shadow: 0 10px 24px rgba(244, 63, 94, 0.22);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            border: none !important;
        }

        .btn:hover { transform: translateY(-1px); transition: all .2s ease; }

        /* --- Tables --- */
        .table thead th {
            border-top: none !important;
            border-bottom: 2px solid #eceafc !important;
            color: var(--adm-muted);
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 700;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: #faf9ff !important;
        }

        .table td { vertical-align: middle; }

        /* --- Alerts / badges --- */
        .alert { border: none !important; border-radius: 12px !important; font-weight: 500; }
        .alert-info { background: #e0e7ff !important; color: var(--adm-primary-dark) !important; }

        .badge { border-radius: 8px; font-weight: 600; }
        .bg-primary, .badge-primary { background: var(--adm-primary) !important; }

        /* --- Footer --- */
        .footer {
            background: transparent;
            color: var(--adm-muted);
        }

        .footer .footer-links a {
            color: var(--adm-muted);
            transition: color .2s ease;
        }

        .footer .footer-links a:hover { color: var(--adm-primary); }
    </style>

    @yield('styles')

    <script src="{{ asset('assets/js/head.js') }}"></script>

</head>

<!-- body start -->

<body data-layout-mode="default" data-theme="light" data-topbar-color="dark" data-menu-position="fixed"
    data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>

    <!-- Begin page -->
    <div id="wrapper">

        @include('admin.nav')
        @include('admin.sidebar')
        <div class="content-page">
            @yield('content')
            @include('admin.footer')
        </div>
    </div>
    <!-- END wrapper -->
    @include('admin.rightbar')


    <!-- Vendor JS -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    @yield('scripts')

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>

</html>
