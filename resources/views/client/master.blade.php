<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'Client Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('frontend/webfonts/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.nice-number.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/add_row_custon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.exzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/multiple-image-video.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/ranger_style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.classycountdown.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    
    <style>
        /* Modern Client Dashboard Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --dash-primary: #4338ca;
            --dash-primary-light: #4f46e5;
            --dash-accent: #f43f5e;
            --dash-accent-dark: #e11d48;
            --dash-ink: #1e293b;
            --dash-muted: #64748b;
            --dash-border: #e2e8f0;
        }

        body {
            background: #f5f7fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Reusable content components (see client/pages/*.blade.php) */
        .dash-page-header {
            margin-bottom: 28px;
        }

        .dash-page-header h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--dash-ink);
            margin-bottom: 6px;
            letter-spacing: -0.01em;
        }

        .dash-page-header h1 i {
            margin-right: 10px;
            color: var(--dash-accent);
        }

        .dash-page-header p {
            color: var(--dash-muted);
            margin: 0;
        }

        .dash-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 6px 24px rgba(30, 41, 59, 0.07);
            border: 1px solid #f1f5f9;
            margin-bottom: 28px;
        }

        .dash-card h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dash-ink);
            margin-bottom: 22px;
        }

        .dash-card h2 i { color: var(--dash-primary-light); margin-right: 8px; }

        .dash-label {
            display: block;
            margin-bottom: 8px;
            color: var(--dash-ink);
            font-weight: 600;
            font-size: 13.5px;
        }

        .dash-input,
        .dash-textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--dash-border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .dash-input:focus,
        .dash-textarea:focus {
            outline: none;
            border-color: var(--dash-primary-light);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .dash-error {
            color: var(--dash-accent-dark);
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .dash-alert {
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-weight: 500;
            border: 1px solid transparent;
        }

        .dash-alert-success { background: #ecfdf5; border-color: #a7f3d0; color: #047857; }
        .dash-alert-error { background: #fef2f2; border-color: #fecaca; color: #b91c1c; }

        .dash-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 26px;
            border: none;
            border-radius: 9px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .dash-btn:hover { transform: translateY(-2px); color: #fff; }

        .dash-btn-primary {
            background: linear-gradient(135deg, var(--dash-primary-light) 0%, #7c3aed 100%);
            color: #fff;
            box-shadow: 0 10px 22px rgba(79, 70, 229, 0.25);
        }

        .dash-btn-danger {
            background: linear-gradient(135deg, var(--dash-accent) 0%, var(--dash-accent-dark) 100%);
            color: #fff;
            box-shadow: 0 10px 22px rgba(244, 63, 94, 0.22);
        }

        .dash-btn-outline {
            background: #fff;
            color: var(--dash-primary-light);
            border: 1.5px solid #e0e7ff;
            box-shadow: none;
        }

        .dash-btn-outline:hover { background: #eef2ff; color: var(--dash-primary-light); }
        .dash-btn-sm { padding: 8px 16px; font-size: 12.5px; }
        .dash-btn-block { width: 100%; }

        .dash-badge {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .02em;
        }

        .dash-badge-warning { background: #fef3c7; color: #92400e; }
        .dash-badge-info { background: #dbeafe; color: #1e40af; }
        .dash-badge-cyan { background: #cffafe; color: #155e75; }
        .dash-badge-success { background: #d1fae5; color: #065f46; }
        .dash-badge-danger { background: #ffe4e6; color: #9f1239; }

        .dash-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dash-table thead tr {
            background: #f8f7ff;
            border-bottom: 2px solid #ece9fb;
        }

        .dash-table th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 700;
            color: var(--dash-primary);
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .dash-table td {
            padding: 15px 16px;
            color: var(--dash-ink);
            border-bottom: 1px solid #f1f5f9;
        }

        .dash-table tbody tr {
            transition: background .2s ease;
        }

        .dash-table tbody tr:hover {
            background: #faf9ff;
        }

        .dash-empty {
            text-align: center;
            padding: 60px 20px;
        }

        .dash-empty i {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 15px;
            display: block;
        }

        .dash-empty h5 {
            color: var(--dash-muted);
            margin-bottom: 14px;
            font-weight: 600;
        }

        /* Sidebar Styling - Premium Modern Design */
        .dashboard_sidebar {
            background: linear-gradient(180deg, #1e1b4b 0%, #3730a3 55%, #4f46e5 100%);
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 0;
            overflow-y: auto;
            box-shadow: 2px 0 25px rgba(0, 0, 0, 0.25);
            z-index: 1000;
            background-attachment: fixed;
        }

        .dashboard_sidebar .close_icon {
            display: none;
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            color: white;
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .dashboard_sidebar .close_icon:hover {
            color: #f43f5e;
            transform: rotate(90deg);
        }

        .dashboard_sidebar .dash_logo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            border-bottom: 2px solid rgba(244, 63, 94, 0.25);
            margin-bottom: 30px;
        }

        .dashboard_sidebar .dash_logo img {
            height: 50px;
            object-fit: contain;
            filter: brightness(150%);
        }

        /* Navigation Links */
        .dashboard_link {
            list-style: none;
            padding: 0 12px;
        }

        .dashboard_link li {
            margin-bottom: 8px;
        }

        .dashboard_link a {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 10px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .dashboard_link a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(244, 63, 94, 0.12);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .dashboard_link a:hover {
            color: #fb7185;
            padding-left: 20px;
            background: rgba(244, 63, 94, 0.16);
            transform: translateX(2px);
        }

        .dashboard_link a.active {
            color: white;
            background: linear-gradient(90deg, rgba(244, 63, 94, 0.32) 0%, rgba(244, 63, 94, 0.1) 100%);
            border-left: 3px solid #f43f5e;
            padding-left: 16px;
            box-shadow: inset -2px 0 8px rgba(244, 63, 94, 0.2);
        }

        .dashboard_link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .dashboard_link a.active i {
            color: #fb7185;
            text-shadow: 0 0 10px rgba(244, 63, 94, 0.5);
        }

        .dashboard_link button {
            width: 100%;
            background: none;
            border: none;
            color: #cbd5e1;
            padding: 12px 16px;
            border-radius: 10px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            overflow: hidden;
        }

        .dashboard_link button::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(239, 68, 68, 0.1);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .dashboard_link button:hover {
            color: #ef4444;
            padding-left: 20px;
            background: rgba(239, 68, 68, 0.15);
            transform: translateX(2px);
        }

        .dashboard_link button i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        #wsus__dashboard {
            margin-left: 280px;
            min-height: 100vh;
            padding: 0;
            background: #f5f7fa;
        }

        /* Top Menu - Enhanced */
        .wsus__dashboard_menu {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .wsusd__dashboard_user {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .wsusd__dashboard_user img {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .wsusd__dashboard_user img:hover {
            border-color: #4f46e5;
            box-shadow: 0 0 12px rgba(79, 70, 229, 0.3);
        }

        .wsusd__dashboard_user a {
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .wsusd__dashboard_user a:hover {
            color: #4f46e5;
        }

        /* Scroll Button */
        .wsus__scroll_btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 999;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
            border: none;
            font-size: 18px;
        }

        .wsus__scroll_btn.active {
            opacity: 1;
            visibility: visible;
        }

        .wsus__scroll_btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.4);
        }

        /* Dashboard Content */
        .dashboard_content {
            background: #f5f7fa;
        }

        /* Scrollbar Styling */
        .dashboard_sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .dashboard_sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .dashboard_sidebar::-webkit-scrollbar-thumb {
            background: rgba(244, 63, 94, 0.35);
            border-radius: 3px;
        }

        .dashboard_sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(244, 63, 94, 0.55);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard_sidebar {
                width: 260px;
            }

            #wsus__dashboard {
                margin-left: 260px;
            }
        }

        @media (max-width: 768px) {
            .dashboard_sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 20px 0;
                margin-bottom: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            #wsus__dashboard {
                margin-left: 0;
                padding: 0;
            }

            .close_icon {
                display: block !important;
            }

            .dashboard_link {
                display: none;
                padding: 0;
            }

            .dashboard_link.active {
                display: block;
            }

            .wsus__scroll_btn {
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
            }
        }

        /* Animated Star Rating */
        .star-rating {
            display: inline-flex;
            flex-direction: row;
            gap: 4px;
        }

        .star-rating .star {
            cursor: pointer;
            font-size: 22px;
            color: #cbd5e1;
            transition: transform .15s ease, color .2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .star-rating .star i {
            transition: color .2s ease, transform .25s cubic-bezier(.34, 1.56, .64, 1);
            color: #f59e0b;
        }

        .star-rating .star:not(.filled) i {
            color: #cbd5e1;
        }

        .star-rating .star.filled i {
            color: #f59e0b;
            transform: scale(1.25);
            filter: drop-shadow(0 0 6px rgba(245, 158, 11, 0.55));
        }

        .star-rating .star.animating i {
            animation: star-pop .35s cubic-bezier(.34, 1.56, .64, 1);
        }

        @keyframes star-pop {
            0%   { transform: scale(1); }
            50%  { transform: scale(1.45); }
            100% { transform: scale(1.25); }
        }
    </style>
</head>

<body>

    <div class="wsus__dashboard_menu">
        <div class="wsusd__dashboard_user">
            <img src="{{ Auth::user()->profilePicture ? asset('storage/profile_pictures/' . Auth::id() . '/' . Auth::user()->profilePicture) : asset('frontend/images/No_Image.png') }}"
                alt="Profile Picture" class="img-fluid">
            <a href="{{ route('client.profile') }}">
                {{ Auth::user()->name }}
            </a>
        </div>
    </div>

    <livewire:notification />
    <section id="wsus__dashboard">
        <div class="container-fluid">
            <div class="dashboard_sidebar">
                <span class="close_icon">
                    <i class="far fa-bars dash_bar"></i>
                    <i class="far fa-times dash_close"></i>
                </span>
                <a href="{{ route('frontend.index') }}" class="dash_logo"><img src="{{ file_exists(public_path('frontend/images/tiarshop-logo.png')) ? asset('frontend/images/tiarshop-logo.png') : asset('frontend/images/logo.png') }}"
                        alt="logo" class="img-fluid" onerror="this.src='{{ asset('frontend/images/logo.png') }}'"></a>
                <ul class="dashboard_link">
                    <li>
                        <a href="{{ route('client.dashboard') }}"
                            @if (Route::currentRouteName() == 'client.dashboard') class="active" @endif>
                            <i class="fas fa-home"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.orders') }}"
                            @if (Route::currentRouteName() == 'client.orders') class="active" @endif><i class="fas fa-box"></i>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.reviews') }}"
                            @if (Route::currentRouteName() == 'client.reviews') class="active" @endif><i class="fas fa-star"></i> Reviews
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.wishlist') }}"
                            @if (Route::currentRouteName() == 'client.wishlist') class="active" @endif><i class="fas fa-heart"></i>
                            Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.profile') }}"
                            @if (Route::currentRouteName() == 'client.profile') class="active" @endif><i class="fas fa-user-circle"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.address') }}"
                            @if (Route::currentRouteName() == 'client.address') class="active" @endif><i class="fas fa-map-marker-alt"></i>
                            Addresses
                        </a>
                    </li>
                    <li style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px; margin-top: 10px;">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            @yield('content')
        </div>
    </section>

    <!--============================
        SCROLL BUTTON START
      ==============================-->
    <div class="wsus__scroll_btn">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!--============================
        SCROLL BUTTON  END
      ==============================-->


    <!--jquery library js-->
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('frontend/js/Font-Awesome.js') }}"></script>
    <!--select2 js-->
    <script src="{{ asset('frontend/js/select2.min.js') }}"></script>
    <!--slick slider js-->
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <!--simplyCountdown js-->
    <script src="{{ asset('frontend/js/simplyCountdown.js') }}"></script>
    <!--product zoomer js-->
    <script src="{{ asset('frontend/js/jquery.exzoom.js') }}"></script>
    <!--nice-number js-->
    <script src="{{ asset('frontend/js/jquery.nice-number.min.js') }}"></script>
    <!--counter js-->
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countup.min.js') }}"></script>
    <!--add row js-->
    <script src="{{ asset('frontend/js/add_row_custon.js') }}"></script>
    <!--multiple-image-video js-->
    <script src="{{ asset('frontend/js/multiple-image-video.js') }}"></script>
    <!--sticky sidebar js-->
    <script src="{{ asset('frontend/js/sticky_sidebar.js') }}"></script>
    <!--price ranger js-->
    <script src="{{ asset('frontend/js/ranger_jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/ranger_slider.js') }}"></script>
    <!--isotope js-->
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <!--venobox js-->
    <script src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <!--classycountdown js-->
    <script src="{{ asset('frontend/js/jquery.classycountdown.js') }}"></script>

    <!--main/custom js-->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    
    <script>
        // Scroll button functionality
        window.addEventListener('scroll', function() {
            const scrollBtn = document.querySelector('.wsus__scroll_btn');
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('active');
            } else {
                scrollBtn.classList.remove('active');
            }
        });

        document.querySelector('.wsus__scroll_btn').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Mobile menu toggle
        document.querySelector('.dash_bar').addEventListener('click', function() {
            document.querySelector('.dashboard_link').classList.add('active');
        });

        document.querySelector('.dash_close').addEventListener('click', function() {
            document.querySelector('.dashboard_link').classList.remove('active');
        });

        /* Animated star rating interaction */
        (function() {
            document.querySelectorAll('.star-rating').forEach(container => {
                const stars = Array.from(container.querySelectorAll('.star'));
                const radios = Array.from(container.querySelectorAll('input[name="rate"]'));

                function setFilled(value) {
                    stars.forEach(star => {
                        const starValue = parseInt(star.dataset.value, 10);
                        star.classList.toggle('filled', starValue <= value);
                        const i = star.querySelector('i');
                        if (starValue <= value) {
                            i.classList.remove('far'); i.classList.add('fas');
                        } else {
                            i.classList.remove('fas'); i.classList.add('far');
                        }
                    });
                    radios.forEach(r => r.checked = parseInt(r.value, 10) === value);
                }

                // Initialize based on current checked radio or data-initial
                const initial = parseInt(container.dataset.initial || '0', 10);
                if (initial > 0) setFilled(initial);

                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => {
                        const val = parseInt(star.dataset.value, 10);
                        setFilled(val);
                    });

                    star.addEventListener('mouseleave', () => {
                        const selected = radios.find(r => r.checked);
                        const val = selected ? parseInt(selected.value, 10) : initial;
                        setFilled(val);
                    });

                    star.addEventListener('click', () => {
                        const val = parseInt(star.dataset.value, 10);
                        star.classList.add('animating');
                        setTimeout(() => star.classList.remove('animating'), 350);
                        setFilled(val);
                    });

                    star.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            star.click();
                        }
                    });
                });
            });
        })();
    </script>
</body>

</html>
