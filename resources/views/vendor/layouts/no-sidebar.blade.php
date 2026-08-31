<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('vendor/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/components.css') }}">
    @yield('styles')
    <style>
        body {
            background: #f1f5f9 !important;
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 10% 15%, rgba(99,102,241,.15) 0%, transparent 35%),
                radial-gradient(circle at 90% 85%, rgba(139,92,246,.15) 0%, transparent 35%),
                radial-gradient(circle at 50% 50%, rgba(236,254,255,.4) 0%, transparent 50%),
                linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%) !important;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(99,102,241,.08) 1px, transparent 0);
            background-size: 24px 24px;
            pointer-events: none;
            z-index: 0;
        }
        .standalone-wrapper {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
            padding: 40px 20px 60px;
        }
        .standalone-header {
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(15,23,42,.06);
            border: 1px solid rgba(255,255,255,.6);
        }
        .standalone-header h1 { margin: 0; font-size: 1.4rem; font-weight: 700; color: #0f172a; }
        .standalone-header .breadcrumb {
            margin: 6px 0 0;
            padding: 0;
            list-style: none;
            font-size: .82rem;
            color: #64748b;
        }
        .standalone-header .breadcrumb li { display: inline; }
        .standalone-header .breadcrumb li + li::before { content: "/"; margin: 0 6px; color: #cbd5e1; }
        .standalone-header .breadcrumb a { color: #6366f1; text-decoration: none; }
        .standalone-card {
            background: rgba(255,255,255,.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 10px 40px rgba(15,23,42,.08);
            border: 1px solid rgba(255,255,255,.6);
        }
        .standalone-card label { font-weight: 600; font-size: .85rem; color: #334155; }
        .standalone-card .form-control {
            border-radius: 8px;
            font-size: .9rem;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            background: rgba(255,255,255,.9);
            transition: all .2s;
        }
        .standalone-card .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.15);
            background: #fff;
        }
        .standalone-card .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 8px;
            padding: 11px 28px;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 4px 14px rgba(99,102,241,.35);
            transition: all .2s;
        }
        .standalone-card .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,.45);
        }
        .map-container { border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }
        #locationMap { height: 280px; }
        .map-info { font-size: .75rem; color: #94a3b8; margin-top: 4px; }
        .section-body { padding: 0 !important; }
    </style>
</head>
<body>
    <div class="standalone-wrapper">
        @yield('content')
    </div>
    <script src="{{ asset('vendor/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/popper.js') }}"></script>
    <script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
    <script src="{{ asset('vendor/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/js/stisla.js') }}"></script>
    @yield('scripts')
</body>
</html>
