<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'ATLAS MALL || Client Dashboard')</title>
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
    <!-- Toastr
     <link href="{{ asset('adminBackend/css/toastr.css') }}" rel="stylesheet" type="text/css" />
     -->
</head>

<body>

    <div class="wsus__dashboard_menu">
        <div class="wsusd__dashboard_user">
            <img src="{{ Auth::user()->profilePicture ? asset('storage/' . Auth::user()->profilePicture) : asset('frontend/images/No_Image.png') }}"
                alt="Profile Picture" class="img-fluid">
            <a href="{{ route('client.profile') }}">
                <p>{{ Auth::user()->name }}</p>
            </a>
        </div>
    </div>

    <section id="wsus__dashboard">
        <div class="container-fluid">
            <div class="dashboard_sidebar">
                <span class="close_icon">
                    <i class="far fa-bars dash_bar"></i>
                    <i class="far fa-times dash_close"></i>
                </span>
                <a href="{{ route('frontend.index') }}" class="dash_logo"><img src="{{ asset($website->logo) }}"
                        alt="logo" class="img-fluid w-50"></a>
                <ul class="dashboard_link">
                    <li>
                        <a href="{{ route('client.dashboard') }}"
                            @if (Route::currentRouteName() == 'client.dashboard') class="active" @endif>
                            <i class="fas fa-tachometer"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.orders') }}"
                            @if (Route::currentRouteName() == 'client.orders') class="active" @endif><i class="fas fa-list-ul"></i>
                            Orders
                        </a>
                    </li>
                    @if (false)
                        <li>
                            <a href="{{ route('client.downloads') }}"
                                @if (Route::currentRouteName() == 'client.downloads') class="active" @endif><i
                                    class="far fa-cloud-download-alt"></i>Downloads
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('client.reviews') }}"
                            @if (Route::currentRouteName() == 'client.reviews') class="active" @endif><i class="far fa-star"></i> Reviews
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.wishlist') }}"
                            @if (Route::currentRouteName() == 'client.wishlist') class="active" @endif><i class="far fa-heart"></i>
                            Wishlist
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.profile') }}"
                            @if (Route::currentRouteName() == 'client.profile') class="active" @endif><i class="far fa-user"></i> My
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.address') }}"
                            @if (Route::currentRouteName() == 'client.address') class="active" @endif><i class="fal fa-gift-card"></i>
                            Addresses
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }} " method="POST">
                            @csrf
                            <button type="submit" class="btn text-white text-start">
                                <i class="far fa-sign-out-alt"></i> Log out
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
</body>

</html>
