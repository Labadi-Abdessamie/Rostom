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

        body {
            background: #f5f7fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Sidebar Styling - Premium Modern Design */
        .dashboard_sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #1e3a8a 50%, #1e40af 100%);
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
            color: #14b8a6;
            transform: rotate(90deg);
        }

        .dashboard_sidebar .dash_logo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            border-bottom: 2px solid rgba(20, 184, 166, 0.2);
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
            background: rgba(20, 184, 166, 0.1);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .dashboard_link a:hover {
            color: #14b8a6;
            padding-left: 20px;
            background: rgba(20, 184, 166, 0.15);
            transform: translateX(2px);
        }

        .dashboard_link a.active {
            color: white;
            background: linear-gradient(90deg, rgba(20, 184, 166, 0.3) 0%, rgba(20, 184, 166, 0.1) 100%);
            border-left: 3px solid #14b8a6;
            padding-left: 16px;
            box-shadow: inset -2px 0 8px rgba(20, 184, 166, 0.2);
        }

        .dashboard_link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .dashboard_link a.active i {
            color: #14b8a6;
            text-shadow: 0 0 10px rgba(20, 184, 166, 0.5);
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
            border-color: #14b8a6;
            box-shadow: 0 0 12px rgba(20, 184, 166, 0.3);
        }

        .wsusd__dashboard_user a {
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .wsusd__dashboard_user a:hover {
            color: #14b8a6;
        }

        /* Scroll Button */
        .wsus__scroll_btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
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
            box-shadow: 0 8px 24px rgba(20, 184, 166, 0.3);
            border: none;
            font-size: 18px;
        }

        .wsus__scroll_btn.active {
            opacity: 1;
            visibility: visible;
        }

        .wsus__scroll_btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(20, 184, 166, 0.4);
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
            background: rgba(20, 184, 166, 0.3);
            border-radius: 3px;
        }

        .dashboard_sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(20, 184, 166, 0.5);
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
                <a href="{{ route('frontend.index') }}" class="dash_logo"><img src="{{ asset($website->logo) }}"
                        alt="logo" class="img-fluid"></a>
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
    </script>
</body>

</html>
