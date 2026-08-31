<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | {{ config('app.name', 'Admin') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard" />
    <meta name="author" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

    <style>
        /* ===== ADMIN DESIGN SYSTEM ===== */
        :root {
            --adm-primary: #4f46e5;
            --adm-primary-dark: #3730a3;
            --adm-accent: #f43f5e;
            --adm-accent-dark: #e11d48;
            --adm-ink: #1e1b4b;
            --adm-muted: #64748b;
            --adm-bg: #f4f5fb;
            --adm-radius: 14px;
            --adm-sidebar-w: 260px;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body { background: var(--adm-bg) !important; margin: 0; }

        /* ========== TOPBAR ========== */
        .adm-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 64px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(30, 27, 75, 0.06);
            border-bottom: 1px solid #ececf7;
            display: flex;
            align-items: center;
            padding: 0 20px;
            z-index: 100;
            gap: 16px;
        }

        .adm-topbar .adm-burger {
            display: none;
            background: linear-gradient(135deg, var(--adm-primary) 0%, #7c3aed 100%);
            color: #fff;
            border: none;
            width: 42px; height: 42px;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
            transition: transform .2s ease;
        }
        .adm-topbar .adm-burger:hover { transform: scale(1.05); }

        .adm-topbar .adm-logo {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--adm-ink);
            letter-spacing: -.01em;
        }

        .adm-topbar .adm-logo-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--adm-primary) 0%, #7c3aed 100%);
            display: inline-flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px;
        }

        .adm-topbar .adm-spacer { flex: 1; }

        .adm-topbar .adm-user {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 14px 6px 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            cursor: pointer;
            transition: all .2s ease;
        }
        .adm-topbar .adm-user:hover {
            background: #eef2ff; border-color: #c7d2fe;
        }
        .adm-topbar .adm-user img {
            width: 36px; height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }
        .adm-topbar .adm-user-name {
            font-weight: 600; color: var(--adm-ink); font-size: 14px;
        }
        .adm-topbar .adm-user-name i { color: var(--adm-muted); margin-left: 4px; }

        /* ========== SIDEBAR ========== */
        .adm-sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--adm-sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 55%, #4338ca 100%);
            z-index: 200;
            display: flex; flex-direction: column;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.25);
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
        }

        .adm-sidebar .adm-sidebar-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 22px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .adm-sidebar .adm-sidebar-header .adm-brand {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 800; font-size: 1.1rem; color: #fff;
            text-decoration: none;
        }
        .adm-sidebar .adm-sidebar-header .adm-brand i { color: var(--adm-accent); }
        .adm-sidebar .adm-sidebar-close {
            display: none;
            background: rgba(255,255,255,.1);
            border: none; color: #fff;
            width: 36px; height: 36px;
            border-radius: 8px;
            cursor: pointer;
            align-items: center; justify-content: center;
            font-size: 18px;
            transition: background .2s ease;
        }
        .adm-sidebar .adm-sidebar-close:hover { background: rgba(244, 63, 94, 0.4); }

        .adm-sidebar .adm-sidebar-body {
            flex: 1; overflow-y: auto; padding: 16px 0 24px;
        }
        .adm-sidebar .adm-sidebar-body::-webkit-scrollbar { width: 6px; }
        .adm-sidebar .adm-sidebar-body::-webkit-scrollbar-track { background: transparent; }
        .adm-sidebar .adm-sidebar-body::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 3px; }

        .adm-sidebar .adm-menu { list-style: none; padding: 0; margin: 0; }
        .adm-sidebar .adm-menu-title {
            color: rgba(255,255,255,.35);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .12em;
            padding: 16px 24px 6px;
        }
        .adm-sidebar .adm-menu li > a {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 18px;
            margin: 2px 12px;
            color: rgba(226, 232, 240, 0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            border-left: 3px solid transparent;
            transition: all .2s ease;
        }
        .adm-sidebar .adm-menu li > a i {
            width: 20px; text-align: center; font-size: 16px;
            color: rgba(226, 232, 240, 0.65);
        }
        .adm-sidebar .adm-menu li > a:hover {
            color: #fff;
            background: rgba(244, 63, 94, 0.18);
            border-left-color: var(--adm-accent);
            padding-left: 22px;
        }
        .adm-sidebar .adm-menu li > a:hover i { color: var(--adm-accent); }
        .adm-sidebar .adm-menu li > a.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(244, 63, 94, 0.3) 0%, rgba(244, 63, 94, 0.05) 100%);
            border-left-color: var(--adm-accent);
        }
        .adm-sidebar .adm-menu li > a.active i { color: var(--adm-accent); }

        .adm-sidebar .adm-menu .has-sub > a .adm-arrow {
            margin-left: auto;
            transition: transform .2s ease;
        }
        .adm-sidebar .adm-menu .has-sub.open > a .adm-arrow { transform: rotate(90deg); }
        .adm-sidebar .adm-menu .sub-menu {
            list-style: none; padding: 4px 0 8px 32px; margin: 0;
            max-height: 0; overflow: hidden;
            transition: max-height .3s ease;
        }
        .adm-sidebar .adm-menu .has-sub.open .sub-menu { max-height: 400px; }
        .adm-sidebar .adm-menu .sub-menu li a {
            display: block;
            padding: 8px 16px;
            color: rgba(226, 232, 240, 0.65);
            text-decoration: none;
            font-size: 13.5px;
            border-radius: 8px;
            margin: 1px 12px;
            transition: all .15s ease;
        }
        .adm-sidebar .adm-menu .sub-menu li a:hover {
            color: #fff; background: rgba(255,255,255,.05); padding-left: 20px;
        }

        /* ========== CONTENT ========== */
        .adm-content {
            margin-left: var(--adm-sidebar-w);
            margin-top: 64px;
            min-height: calc(100vh - 64px);
            padding: 28px;
        }

        /* ========== OVERLAY ========== */
        .adm-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(2px);
            z-index: 150;
        }
        .adm-overlay.active { display: block; }

        /* ========== PAGE TITLE ========== */
        .page-title-box .page-title { font-weight: 800; color: var(--adm-ink); }

        /* ========== CARDS / TABLES / BUTTONS ========== */
        .card { border: none !important; border-radius: var(--adm-radius) !important; box-shadow: 0 4px 20px rgba(30, 27, 75, 0.07) !important; }
        .card .card-body { padding: 1.5rem; }
        .card-header { background: transparent !important; border-bottom: 1px solid #f1f5f9 !important; padding: 16px 20px !important; font-weight: 700; font-size: .95rem; color: var(--adm-ink); }
        .header-title { font-weight: 800 !important; color: var(--adm-ink) !important; font-size: 1rem; }

        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: .75rem; font-weight: 700; letter-spacing: .01em; }
        .sb-pending, .sb-inactive { background: #fef9c3; color: #854d0e; }
        .sb-delivered, .sb-active, .sb-confirmed { background: #dcfce7; color: #166534; }
        .sb-processing, .sb-shipped { background: #dbeafe; color: #1e40af; }
        .sb-cancelled, .sb-blocked { background: #fee2e2; color: #991b1b; }

        .btn { border-radius: 10px !important; font-weight: 600 !important; }
        .btn-primary { background: linear-gradient(135deg, var(--adm-primary) 0%, #7c3aed 100%) !important; border: none !important; box-shadow: 0 10px 24px rgba(79, 70, 229, 0.25); }
        .btn-primary:hover { box-shadow: 0 14px 30px rgba(79, 70, 229, 0.35); transform: translateY(-1px); }
        .btn-danger { background: linear-gradient(135deg, var(--adm-accent) 0%, var(--adm-accent-dark) 100%) !important; border: none !important; box-shadow: 0 10px 24px rgba(244, 63, 94, 0.22); }
        .btn-success { background: linear-gradient(135deg, #059669 0%, #047857 100%) !important; border: none !important; }
        .btn:hover { transform: translateY(-1px); transition: all .2s ease; }

        .table thead th { border-top: none !important; border-bottom: 2px solid #eceafc !important; color: var(--adm-muted); font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; font-weight: 700; }
        .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: #faf9ff !important; }
        .table td { vertical-align: middle; }

        .alert { border: none !important; border-radius: 12px !important; font-weight: 500; }
        .alert-info { background: #e0e7ff !important; color: var(--adm-primary-dark) !important; }
        .badge { border-radius: 8px; font-weight: 600; }
        .bg-primary, .badge-primary { background: var(--adm-primary) !important; }

        .footer { background: transparent; color: var(--adm-muted); }
        .footer .footer-links a { color: var(--adm-muted); transition: color .2s ease; }
        .footer .footer-links a:hover { color: var(--adm-primary); }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .adm-sidebar { width: 240px; --adm-sidebar-w: 240px; }
        }

        @media (max-width: 768px) {
            .adm-topbar { padding: 0 16px; }
            .adm-topbar .adm-burger { display: inline-flex; }
            .adm-topbar .adm-user-name { display: none; }

            .adm-sidebar {
                transform: translateX(-100%);
                width: 300px;
            }
            .adm-sidebar.open { transform: translateX(0); }
            .adm-sidebar .adm-sidebar-close { display: inline-flex; }

            .adm-content {
                margin-left: 0;
                padding: 18px 16px;
            }
        }
    </style>

    @yield('styles')

</head>

<body>

    <!-- TOPBAR -->
    <header class="adm-topbar">
        <button class="adm-burger" id="admBurger" aria-label="Open menu">
            <i class="fas fa-bars"></i>
        </button>

        <a href="{{ route('frontend.index') }}" class="adm-logo">
            <span class="adm-logo-icon"><i class="fas fa-shield-halved"></i></span>
            <span>{{ config('app.name', 'TiarShop') }} Admin</span>
        </a>

        <div class="adm-spacer"></div>

        <div class="adm-user" onclick="document.getElementById('admUserDropdown').classList.toggle('open')" style="position:relative;">
            <img src="{{ Auth::user()->profilePicture ? asset('storage/profile_pictures/' . Auth::id() . '/' . Auth::user()->profilePicture) : asset('frontend/images/No_Image.png') }}" alt="user">
            <span class="adm-user-name">
                {{ Auth::user()->name }}
                <i class="fas fa-chevron-down"></i>
            </span>

            <div id="admUserDropdown" style="display:none; position:absolute; top:calc(100% + 10px); right:0; background:#fff; border-radius:12px; box-shadow:0 20px 45px rgba(30,27,75,.18); min-width:200px; padding:8px 0; z-index:200;">
                <a href="{{ route('admin.profile') }}" style="display:flex; align-items:center; gap:10px; padding:10px 18px; color:var(--adm-ink); text-decoration:none; font-size:14px; font-weight:500;">
                    <i class="fas fa-user" style="color:var(--adm-primary); width:18px;"></i> My Account
                </a>
                <div style="height:1px; background:#e2e8f0; margin:6px 0;"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" style="display:flex; align-items:center; gap:10px; padding:10px 18px; width:100%; background:none; border:none; color:var(--adm-accent-dark); font-size:14px; font-weight:600; cursor:pointer; text-align:left;">
                        <i class="fas fa-sign-out-alt" style="width:18px;"></i> Log out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- OVERLAY -->
    <div class="adm-overlay" id="admOverlay"></div>

    <!-- SIDEBAR -->
    @include('admin.sidebar')

    <!-- CONTENT -->
    <main class="adm-content">
        @yield('content')
        @include('admin.footer')
    </main>

    <script>
        (function() {
            const sidebar = document.querySelector('.adm-sidebar');
            const overlay = document.getElementById('admOverlay');
            const burger = document.getElementById('admBurger');
            const closeBtn = document.querySelector('.adm-sidebar-close');
            const dropdown = document.getElementById('admUserDropdown');

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('active');
            }
            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }

            if (burger) burger.addEventListener('click', openSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

            // Close sidebar when a REAL navigation link is clicked (not submenu toggles)
            document.querySelectorAll('.adm-sidebar a').forEach(a => {
                a.addEventListener('click', (e) => {
                    // Don't close if this is a submenu toggle (has href="#" and parent is has-sub)
                    const isSubmenuToggle = a.parentElement.classList.contains('has-sub');
                    if (!isSubmenuToggle && window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });

            // Close user dropdown on outside click
            document.addEventListener('click', (e) => {
                if (dropdown && !e.target.closest('.adm-user')) {
                    dropdown.style.display = 'none';
                }
            });
            // Override the inline toggle
            window.addEventListener('DOMContentLoaded', () => {
                const user = document.querySelector('.adm-user');
                if (user && dropdown) {
                    user.addEventListener('click', (e) => {
                        e.stopPropagation();
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                    });
                }
            });

            // Submenu toggle — only fires for parent toggle links, persists state
            document.querySelectorAll('.adm-menu .has-sub > a').forEach(a => {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const li = a.parentElement;
                    // Close other open submenus (accordion behavior)
                    document.querySelectorAll('.adm-menu .has-sub.open').forEach(other => {
                        if (other !== li) other.classList.remove('open');
                    });
                    li.classList.toggle('open');
                });
            });

            // Auto-open the submenu that contains the currently active link
            document.querySelectorAll('.adm-sidebar a.active').forEach(activeLink => {
                const parentLi = activeLink.closest('.has-sub');
                if (parentLi) parentLi.classList.add('open');
            });
        })();
    </script>

    @yield('scripts')

</body>

</html>
